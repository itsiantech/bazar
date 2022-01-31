<?php

namespace App\Models;

use App\Packages\Shop\ShopManager;
use Carbon\Carbon;
use DebugBar\DebugBar;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;

class Order extends Model
{
    use Notifiable;

    public $userAccessToken,$slackWebHookChannel;

    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'user_id',
        'owner_id',
        'discount_id',
        'address_id',
        'payment_method_id',
        'amount',
        'unique_order_id',
        'coupon_id',
        'delivery_charge_id',
        'delivery_charge',
        'total_saved',
        'wallet_reduction',
        'cash_back',
        'schedule'
    ];

    protected $operations = [
        'pending' => 'getPendingOrdersByDateRange',
        'delivered' => 'getDeliveredOrdersByDateRange',
        'undelivered' => 'getUndeliveredOrders',
        'accepted' => 'getAcceptedOrdersByDateRange',
        'on_way' => 'getOnWayOrdersByDateRange',
        'all' => 'getOrdersByDateRange',
    ];


    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function statusLog()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function deliveryCharge()
    {
        return $this->belongsTo(DeliveryCharge::class);
    }

    public function routeNotificationForSlack($notification)
    {
        return $this->slackWebHookChannel;
    }
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
    /****************************
     * Public Methods area
     *****************************/

    /***
     * Method to get data.
     * @param $data
     * @return
     */

    public function getOperationByState($state)
    {
        $default = 'getOrdersByDateRange';

        if(!$state) $state = 'order';

        return array_key_exists($state, $this->operations)?$this->operations[$state]:$default;

    }

    public function checkOperationHasState($state):bool
    {
       return array_key_exists($state, $this->operations);
    }

    public function GetData($data)
    {
        return $this->ObjectToArray($data);
    }

    public function slackChannel(String $channelConfig)
    {
        $this->slackWebHookChannel = config($channelConfig);

        return $this;
    }

    public function GetCouponId($coupon)
    {
        if (isset($coupon->coupon_id)) {

            $couponId = $coupon->coupon_id;
            $coupon = Coupon::find($couponId);
            if (empty($coupon)) return null;

            $couponFreq = $coupon->CheckFrequency($coupon);
            if ($couponFreq == 0) {
                return null;
            }

            if ($couponFreq == 2) {
                UserCoupon::create(['user_id' => auth()->id(), 'coupon_id' => $couponId, 'frequency' => 1]);
                return $couponId;

            }
            UserCoupon::where('user_id', auth()->id())->where('coupon_id', $couponId)->limit(1)->increment('frequency');
            return $couponId;
        }

        return null;
    }

    public function GetOrders($state)
    {
        if ($state == '') return $this->GetDailyOrders();

        if ($state == 'daily') return $this->GetDailyOrders();

        if ($state == 'all') return $this->all();

        if ($state == 'new') return $this->NewOrders('pending');

        if ($state == 'delivered') return $this->DeliveredOrders();

        if ($state == 'undelivered') return $this->UndeliveredOrders();

        return $this->GetOrderByStatus($state);

    }

    public function performDateRangeFilterOperation(string $start, string $end, string $state = null)
    {
        $start = Carbon::createFromFormat("!Y-m-d", $start);
        $end = Carbon::createFromFormat("!Y-m-d", $end);

        if(method_exists($this, $this->getOperationByState($state)))
        {
            return $this->{$this->operations[$state]}($start, $end);
        }

        return [];
    }

    public static function all($key = null)
    {
        return Order::with('user', 'paymentMethod')->orderByDesc('id')->get();
    }

    public function getOrdersByDateRange(Carbon $start, Carbon $end)
    {
        return Order::with('user', 'paymentMethod')->whereBetween('orders.created_at', [$start, $end])->orderByDesc('id')->get();
    }

    public function getPendingOrdersByDateRange(Carbon $start, Carbon $end)
    {
        return Order::with('user', 'paymentMethod')->where('status', 'pending')->whereBetween('orders.created_at', [$start, $end])->orderByDesc('id')->get();
    }

    public function getDeliveredOrdersByDateRange(Carbon $start, Carbon $end)
    {
        return Order::with('user', 'paymentMethod')->where('status', 'delivered')->whereBetween('orders.created_at', [$start, $end])->orderByDesc('id')->get();
    }

    public function getAcceptedOrdersByDateRange(Carbon $start, Carbon $end)
    {
        return Order::with('user', 'paymentMethod')->where('status', 'accepted')->whereBetween('orders.created_at', [$start, $end])->orderByDesc('id')->get();
    }

    public function getOnWayOrdersByDateRange(Carbon $start, Carbon $end)
    {
        return Order::with('user', 'paymentMethod')->where('status', 'on_way')->whereBetween('orders.created_at', [$start, $end])->orderByDesc('id')->get();
    }

    public function getUndeliveredOrders(Carbon $start, Carbon $end)
    {
        return Order::with('user', 'paymentMethod')->where('status','<>', 'delivered')->whereBetween('orders.created_at', [$start, $end])->orderByDesc('id')->get();
    }


    public function GetDailyOrders()
    {
        return Order::with('user', 'paymentMethod')->where('orders.created_at', '>=', Carbon::today())->orderByDesc('id')->get();

    }

    public function NewOrders($status)
    {
        return Order::with('user', 'paymentMethod')->where('orders.status', $status)->where('orders.created_at', '>=', Carbon::today())->orderByDesc('id')->get();

    }

    public function DeliveredOrders()
    {
        return Order::with('user', 'paymentMethod')->where('status', 'delivered')->orderBy('id','desc')->get();

    }

    public function UndeliveredOrders()
    {
        return Order::with('user', 'paymentMethod')->where('status', '<>','delivered')->orderBy('id','desc')->get();
    }

    public function GetOrderByStatus($status)
    {
        return Order::with('user', 'paymentMethod')->where('orders.status', $status)->orderByDesc('id')->get();
    }

    public function GetDetail($id)
    {
        return Order::with('user', 'user.wallet','paymentMethod', 'address', 'orderItems.product', 'discount', 'coupon', 'deliveryCharge')->where('orders.id', $id)->first();

    }

    public function GetOrderByUser()
    {
        return Order::with('paymentMethod', 'address', 'orderItems.product')->where('user_id', Auth::user()->id)->orderByDesc('id')->get();

    }

    public static function TotalSalesAmount()
    {
        return Order::where('status', 'done')->orwhere('status', 'delivered')->sum('amount');
    }

    public function CheckBundle($products)
    {

        foreach ($products as $product) {
            if ($product->is_bundle == 1) {

                $this->GetBundleProducts($product->product_id);
            }
        }
        return $products;
    }

    public function GetBundleProducts($id)
    {
        return Bundle::with('products')->find($id);
    }

    public function ObjectToArray($orderObject)
    {
//        $coupon = new Coupon();
        $data['payment_method_id'] = $orderObject->payment_method_id;
        $data['address_id'] = $orderObject->address_id;
        $data['user_id'] = Auth::user()->id;
        $data['amount'] = $orderObject->amount;
        $data['delivery_charge_id'] = null;
        $data['coupon_id'] = $this->GetCouponId($orderObject);
        $data['wallet_reduction'] = $orderObject->wallet_reduction;
        $data['schedule'] = $orderObject->schedule;
        return $data;
    }

    public function GetAndUpdateOrderAmount($id, $couponIdentifier)
    {

        $shop = new ShopManager($id, $couponIdentifier);

        return $shop->UpdateOrderAmount();
    }


    public function calculateCurrentAmountProducts($products):array
    {
        $orderAmount = 0;
        $discount = 0;

        foreach ($products as $item) {

            $orderAmount += (($item->product->price_en - $item->product->discount) * $item->quantity);

            if ($item->product->discount > 0 || $item->product->discount != null) {
                $discount += $item->product->discount * $item->quantity;
            }
        }

        return [$orderAmount, $discount];
    }


    public function getOrderDeliveryCharge($amount)
    {
        $charge = DeliveryCharge::where('minimum_amount', '<=', $amount)->where('maximum_amount', ">=", $amount)->first();
        if (empty($charge)) {
            return DeliveryCharge::select('id', 'charge_amount')->first();
        }

        return $charge->toArray();
    }


    public function AddDiscountToOrder($orderId, $id)
    {
        //dd($id);
        $data['discount_id'] = ($id == "NULL" ? NULL : $id);
        $order = Order::find($orderId);
        return $order->update($data);
    }

    public function UniqueOrderId($orderId = 0)
    {
        $carbon = Carbon::now();
        $orderId = strtoupper($carbon->shortMonthName) . $carbon->day . $this->ShortYear($carbon->year) . $orderId;
        return $orderId;
    }

    public function UpdateUniqueOrderId($id)
    {
        $data['unique_order_id'] = $this->UniqueOrderId($id);
        $order = Order::find($id);

        return $order->update($data);
    }

    public function ShortYear($year)
    {
        return substr($year, 2);
    }

    /****************************
     * private Methods area
     *****************************/


    public function CalculateTotalAmount($orderObject)
    {
        $totalAmount = 0;
        foreach ($orderObject->orderItems as $item) {
            $totalAmount += $item->price;
        }
        return $totalAmount;
    }

    public function GetAmount($data)
    {
        $products = $data->orderItems;
        $discount = $data->discount;
        $coupon = $data->coupon;
        $total['itemTotal'] = self::GetTotalPrice($products);
        $total['deliveryCharge'] = (!empty($coupon) && $coupon->is_free_delivery) ? 0 : self::GetDeliveryChargeAmount($data->deliveryCharge);
        $total['discount'] = self::GetDiscountAmount($total['itemTotal'], $discount);
        $total['coupon'] = self::GetCouponAmount($total['itemTotal'] - $data['total_saved'], $coupon);
        $total['deduction'] = self::GetTotalDeducted($total['discount'], $total['coupon']);
        $total['totalSaved'] = $data['total_saved'];
//        $total['netTotal'] = ($total['deliveryCharge'] + $total['itemTotal']) - $total['deduction'];
        $total['netTotal'] = ($total['deliveryCharge'] + $total['itemTotal']) - $total['deduction'] - $total['totalSaved'];
//        $total['netTotal'] = ($total['deliveryCharge']+$total['itemTotal'])-$total['deduction'];
        return $total;
    }

    public static function GetTotalPrice($products)
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += self::GetProductPrice($product);
        }
        //dd($totalPrice);
        return $totalPrice;
    }

    public static function GetProductPrice($product)
    {
        //$productPrice = $product->product->price_en+self::GetPercentInValue($product->product->price_en,$product->product->vat_percent);
        $productPrice = $product->price + self::GetPercentInValue($product->price, $product->product->vat_percent);
        $productPrice = $productPrice * $product->quantity;

        return $productPrice;
    }

    public function GetTotalDeducted($discount, $coupon)
    {
        return $discount + $coupon;
    }

    public static function GetPercentInValue($amount, $percent)
    {
        return floatval((intval($percent) * intval($amount)) / 100);
    }

    public static function GetDiscountAmount($total, $discount)
    {
        if ($discount != null) {
            if ($discount->is_percent == 1) {
                return self::GetPercentInValue($total, $discount->amount);
            }
            return $discount->amount;
        }
        return 0;
    }

    public static function GetCouponAmount($total, $coupon)
    {
        if ($coupon != null) {
            if($coupon->is_cash_back) return 0;

            if ($coupon->is_percent == 1) {
                return self::GetPercentInValue($total, $coupon->amount);
            }
            return $coupon->amount;
        }
        return 0;
    }

    public static function GetDeliveryChargeAmount($deliveryCharge)
    {
        if ($deliveryCharge != null) {
            return $deliveryCharge->charge_amount;
        }
        return 0;
    }


    public function calculateOriginalAmountAfterDiscount($order = null)
    {
        if ($order == null) $order = $this;

        $amount = $order->amount;

        $couponIdentifier = $order->coupon_id;
        $coupon = (new Coupon())->CheckCoupon($couponIdentifier, $order->amount, true);

        $couponAmount = 0;
        if (array_key_exists('success', $coupon) && $coupon['success']) {
            $couponAmount = $coupon['reducedAmount'];
        }

        $amount = $amount - $couponAmount ;


        if (!empty($discount = $order->discount)) {

            if (!$discount->is_percent)
                return $amount - $discount->amount;

            return $amount - $amount * (($discount->amount ? $discount->amount : 0) / 100);
        }

        return $amount;
    }

    public function gatewayPayableAmount($order = null)
    {
        if ($order == null) $order = $this;

        $amount = $this->calculateOriginalAmountAfterDiscount($order);

        return $amount - $order->wallet_reduction??0.0;
    }
}
