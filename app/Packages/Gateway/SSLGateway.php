<?php


namespace App\Packages\Gateway;


use App\Events\OrderSuccessEvent;
use App\Models\Order;
use App\Models\SSLPaymentTransaction;
use App\Packages\Gateway\Contracts\Gateway;
use App\Packages\Wallet\WalletManager;
use App\Services\OrderService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class SSLGateway implements Gateway
{
    public function processPayment(float $amount, Order $order):string
    {
        $amount = $order->gatewayPayableAmount();

        $post_data = array();
        $post_data['store_id'] = "bangoshoplive";
        $post_data['store_passwd'] = "5F61D585BA44294481 ";
        $post_data['total_amount'] = $amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $order->unique_order_id??"bangoshop".uniqid();
        $post_data['ipn_url'] = url("api/orders/ssl_ipn_listener");
        $post_data['value_a'] = $order->id;
        $post_data['success_url'] = env('APP_URL') ."/orders/payment/success";
        $post_data['fail_url'] = env('APP_URL') ."/orders/payment/failed";
        $post_data['cancel_url'] = env('APP_URL') ."/orders/payment/canceled";



        # CUSTOMER INFORMATION
        $post_data['cus_name'] = "";
        $post_data['cus_add1'] = "Dhaka";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '';



        # REQUEST SEND TO SSLCOMMERZ
        $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
//        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


        $content = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            return json_encode(['status' => 'fail', 'data' => null, 'message' => "FAILED TO CONNECT WITH SSLCOMMERZ API"]);
        }

        # PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            // this is important to show the popup, return or echo to sent json response back
            try{
//                event(new SuccessfulOrderNotification($order));
                event(new OrderSuccessEvent($order));
            }catch (\Exception $e){
                return json_encode([
                    'status'    => 'success',
                    'data'      => $sslcz['GatewayPageURL'],
                    'logo'      => $sslcz['storeLogo'],
                    'error'     => ['message' => $e->getMessage()]
                ]);
            }
            return json_encode(['status' => 'success', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo']]);
        } else {
            return json_encode(['status' => 'fail', 'data' => null, 'message' => "JSON Data parsing error!"]);
        }
    }


    public function ipnListener(array $transaction_data):bool
    {
        $order_id = $transaction_data['value_a'];

        $transaction_data['order_id'] = $order_id;

        $transaction = SSLPaymentTransaction::create($transaction_data);

        $transaction->load('order','order.user');

        return $this->ValidateSSLPayment($transaction);
    }

    public function validateSSLPayment(SSLPaymentTransaction $transaction):bool
    {
        if($transaction->status != "VALID"){

            try
            {
                (new OrderService())->ChangeOrderStatus($transaction['order_id'], "canceled");
            }
            catch (QueryException $ex)
            {
                echo "Query Exception Occurred";
            }
            catch (\Exception $e)
            {
                echo $e->getMessage();
            }

            return false;
        }

        try{
            $val_id=urlencode($transaction->val_id);
            $store_id=urlencode("bangoshoplive");
            $store_passwd=urlencode("5F61D585BA44294481");
//        $requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");
            $requested_url = ("https://securepay.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $requested_url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

            $result = curl_exec($handle);

            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if($code == 200 && !( curl_errno($handle)))
            {

                $result = json_decode($result);

                # TRANSACTION INFO
                $status = $result->status;
                $tran_date = $result->tran_date;
                $tran_id = $result->tran_id;
                $val_id = $result->val_id;
                $store_amount = $result->store_amount;
                $bank_tran_id = $result->bank_tran_id;
                $card_type = $result->card_type;

                $amount = $result->amount;

                $transaction->update(['status' => 'verified']);

                $order = $transaction->order;

                $order->increment('wallet_reduction', $amount);

                $this->createTransaction($amount, $order);

                $this->makeOrderAccept($order);

                return true;

            } else {
                $transaction->update(['status' => 'NOT_FOUND']);

                return false;
            }
        }catch (\Exception $ex){
            Log::error("SSL Validation failed", [
                'errorMessage' => $ex->getMessage()
            ]);

            return false;
        }

    }

    public function createTransaction($amount, $order)
    {
        try {
            $wallet = new WalletManager($order->user, $order);
            $wallet->createTransaction(['amount' => 0 - $amount]);
        }catch (\Throwable $exception)
        {
            $message = 'Exception occurred while creating ssl transaction. Order id:'.$order->id;
            Log::emergency($message, [
                'message' => $exception->getMessage(),
                'order' => $order,
                'user' => $order->user,
                'exception' => $exception
            ]);
        }

    }

    public function makeOrderAccept($order)
    {
        try {
            $status = new OrderService();
            $status->ChangeOrderStatus($order->id, 'accepted');
        }catch (\Throwable $exception)
        {
            $message = 'Exception occurred while changing order status to accepted during ssl payment. Order id:'.$order->id;
            Log::emergency($message, [
                'message' => $exception->getMessage(),
                'order' => $order,
                'user' => $order->user,
                'exception' => $exception
            ]);
        }
    }
}
