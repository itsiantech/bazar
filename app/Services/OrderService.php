<?php


namespace App\Services;


use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public $globalObject;
    private $moduleName = "Order";
    private $singularVariableName = 'order';
    private $pluralVariableName = 'orders';
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new OrderStatus();
    }

    public function GetOrderItemsArray($orderItems,$orderId)
    {
        $data[]=[];
        $products[] = [];

        foreach ($orderItems as $k=>$item)
        {
            $product = Product::find($item->product_id);

            if(!empty($product))
            {
                $price = $product->price_en;

                $data[$k]['product_id']=$item->product_id;
                $data[$k]['order_id']=$orderId;
                $data[$k]['quantity']=is_null($product->cart_limit)?$item->quantity:$product->cart_limit;
                $data[$k]['price']= $price;
                $data[$k]['is_bundle']= 0;
                $data[$k]['created_at']=Carbon::now();
                $data[$k]['updated_at']=Carbon::now();
                $products[$k] = $product;
            }
        }
        return [$data, $products];
    }

    public function ChangeOrderStatus($id, $status)
    {
        if ($this->globalObject->ChangeOrderStatus($id,$status))
        {
            $this->sendOrderAcceptedMessage($id, $status);

            $this->globalObject->create(['order_id' => $id, 'status' => $status]);

            return true;
        }

        return false;
    }

    private function sendOrderAcceptedMessage($id,$status):bool
    {
        $permittedStatus = ['accepted', 'canceled'];

        if(!in_array($status, $permittedStatus)) return false;

        $order = Order::with(['address','statusLog' => function($q) use($status){
            $q->where('status', $status);
        }])->find($id);

        if(!empty($order)){
            $orderPreviousStatus = $order->statusLog;

            if(count($orderPreviousStatus) == 0){
                $address = $order->address;

                $phone = $address->receiver_phone;

                $uniqueOrderId = $order->unique_order_id;

                $message = "Hello! Your order #$uniqueOrderId has been $status.Our team will communicate with you soon.\nThank you!";
                $smsGateway = new MessageService();
                return $smsGateway->sendSms($phone, $message);
            }

        }
        Log::error("OrderService Order not found for sending sms.Order Id:$id",);
        return false;

    }

    public function getOrderDetail($order, $userHasPermissionToModifyOrder = false)
    {
        $this->singleData = $order;
        $total = (new Order)->GetAmount($this->singleData);
        if(!$userHasPermissionToModifyOrder){
            return [
                $this->singularVariableName => $this->singleData,
                'total' => $total,
            ];
        }

        $discounts = Discount::all();
        $products = Product::all();

        return view('admin.' . $this->pluralVariableName . '.show', [
            $this->singularVariableName => $this->singleData,
            'discounts' => $discounts,
            'products' => $products,
            'total' => $total,
        ]);
    }

}
