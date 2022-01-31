<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OrderSuccessfulEvent;
use App\Events\SuccessfulOrderNotification;
use App\Http\Resources\OrderItemsResource;
use App\Http\Resources\ReOrderStatusResource;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\PersonalTokenModel;
use App\Models\SSLPaymentTransaction;
use App\Notifications\OrderCreatedSlackNotification;
use App\Packages\Gateway\BKASHGateway;
use App\Packages\Gateway\SSLGateway;
use App\Packages\Shop\WalletLoggedInUser;
use App\Packages\Wallet\WalletManager;
use App\Services\OrderService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Validator;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Events\OrderSuccessEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Notifications\OrderConfirmation;
use App\Mail\OrderNotifyToAdminMail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private $message;
    private $moduleName = "Order";
    private $singularVariableName = 'order';
    private $pluralVariableName = 'Orders';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Order();
    }

    public function tractOrder(Order $order)
    {
        return response(new OrderResource($order));
    }
    public function InitiatePayment(Request $request)
    {
        $user = auth()->user();
        if(!$user->is_activated)
            return ['status' => 'fail', 'data' => null, 'message' => "User is deactivated"];

        $data = $request->cart_json;

        if(empty($data)){
            return ['status' => 'fail', 'data' => null, 'message' => "Cart json required"];
        }

        if(!is_array($data)){
            return ['status' => 'fail', 'data' => null, 'message' => "Data is not an array"];
        }

        $rules = [
            'order' => 'required|array',
            'order.user_id' => 'required',
            'order.payment_method_id' => 'required',
            'order.delivery_charge_id' => 'required',
            'order.address_id' => 'required',
            'order.orderItems' => 'required|array',
            'order.orderItems.*.product_id' => 'required',
            'order.orderItems.*.name' => 'required',
            'order.orderItems.*.quantity' => 'required',
            'order.orderItems.*.price' => 'required',
            'order.amount' => 'required',
            'order.schedule' => 'present|nullable|date_format:Y-m-d H:i:s|after:now',
            'order.wallet_reduction' => ["present","nullable","numeric","min:0"]
        ];

        if(request('cart_json.order.wallet_reduction') > 0){
            $userWallet = new WalletManager(auth()->user());
            $wallet = $userWallet->findWallet();
            $walletAmount = $wallet->balance??0;
            array_push($rules['order.wallet_reduction'], 'max:'.$walletAmount);
        }


        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {

            try {
                $processed_data = $this->globalObject->GetData(json_decode(json_encode($data['order'])));
                $order = $this->globalObject->create($processed_data);
                if ($order) {
                    if ($this->globalObject->UpdateUniqueOrderId($order->id)) {
                        $order = Order::findOrFail($order->id);
                        $amount = $this->globalObject->GetAndUpdateOrderAmount($order->id,
                            array_key_exists('coupon_id', $processed_data)?$processed_data['coupon_id']:null);
                        $this->message = 'Order Placed Successfully ';


                            $main_url="https://api.bangoshop.com/";
                            $middle_url = "private-panel/orders/detail/";

                            if(env('APP_ENV')== "local"){
                                $main_url = "http://127.0.0.1:8000/";
                            }

                            $order_url = $main_url.$middle_url.$order->id;

                            Mail::to($user->email)->send(new OrderConfirmationMail($order));
                            Mail::to(env('ORDER_TO_ADMIN_MAIL'))->send(new OrderNotifyToAdminMail($order_url));


                        if($order->payment_method_id == 4){
                            return (new SSLGateway())->processPayment($amount, $order);
                        }

                        if($order->payment_method_id == 5){
                            return (new SSLGateway())->processPayment($amount, $order);
                        }
                        else{
                            try{
                                event(new OrderSuccessEvent($order));

                            }catch (\Exception $e){
                                return response()->json([
                                    'status' => 'ok',
                                    'message' => $this->message,
                                    'error' => ['message' => $e->getMessage()]
                                ]);
                            }
                            return response()->json([
                                'status' => 'ok',
                                'message' => $this->message
                            ]);

                        }

                    } else {
                        $this->message = 'Order could not saved';

                    }
                }
            } catch (QueryException $ex) {

                $this->message = $ex->getMessage();

                if(config('app.env') == 'local'){
                    $this->message = $ex->getMessage().":".$ex->getLine().":".$ex->getFile();
                }
            }catch(\Exception $e){

                $this->message = $e->getMessage();

                if(config('app.env') == 'local'){
                    $this->message = $e->getMessage().":".$e->getLine().":".$e->getFile();
                }

            }

            return json_encode(['status' => 'fail', 'data' => null, 'message' => $this->message]);

        } else {

            return response($validator->errors()->all(), 422);
        }
    }

    public function ReorderCurrentStatus(Order $order)
    {
        $orderItems = $order->orderItems;

        [$amount, $discount] = $this->globalObject->calculateCurrentAmountProducts($orderItems);

        return [
            'data' => [
                'products' => OrderItemsResource::collection($orderItems),
                'amount' => $amount,
                'discount' => $discount
            ],
            'status' => 200
        ];
    }


    public function checkUserLoggedInWithToken($token)
    {

        $token = explode('|',$token);


        if(count($token) > 1){
            $token = end($token);
        }else{
            $token = $token[0];
        }


        $token = hash('sha256', $token);
        $accessToken = PersonalTokenModel::where('token',$token)->first();


        if (! $accessToken || ($accessToken->created_at->lte(now()->subMinutes(config('sanctum.expiration')?config('sanctum.expiration'):120)))) {

            return false;
        }

        $this->globalObject->userAccessToken = $accessToken;

        return $accessToken->user;
    }


    // public function processPayment($amount, $order)
    // {
    //     return (new SSLGateway())->processPayment($amount, $order);
    // }

    // public function SSLIpnListener(Request $request)
    // {
    //     return (new SSLGateway())->ipnListener($request->all());
    // }


    public function PaymentSuccessFul()
    {
        return view('payment_successful');
    }

    public function PaymentFailure()
    {
        return view('payment_failure');
    }
    public function PaymentCanceled()
    {
        return view('payment_canceled');
    }


    public function GetOrdersByUser()
    {
        return response(OrderResource::collection($this->globalObject->GetOrderByUser()), 200);
    }

    public function GetOrderDetail($orderId)
    {
        return response()->json([
            'status' => 'ok',
            'order' => 'object'
        ]);
    }

    public function VerifyOrder(Request $request, $orderId)
    {
        $order = Order::find($orderId);

    }

    public function getOrderDetails($id)
    {
        $this->singleData = $this->globalObject->GetDetail($id);

        if($this->singleData->user_id != auth()->user()->id) abort(403);

        return (new OrderService())->getOrderDetail($this->singleData, false);
    }

    public function getOrderDetailsOrderUniqueId(string $uniqueOrderId, string $phone)
    {
        $order = Order::where('unique_order_id', $uniqueOrderId)->leftJoin('addresses', 'orders.address_id', '=', 'addresses.id')
            ->whereNotNull('addresses.receiver_phone')
            ->where('addresses.receiver_phone',$phone)
            ->select('orders.*')
            ->first();

        if(!empty($order)) $order->load('address');
        if(!empty($order)) return response(new OrderResource($order));

        return [
          'status' => 404,
          'message' => 'Order Not Found'
        ];


    }

    public function bkash(BKASHGateway $gateway)
    {
        $token = $gateway->getToken();
//        $dta = $gateway->getCachedData();
//        $token = $gateway->refreshToken($dta['bkash_refresh_token']);
        return $token;

    }




}
