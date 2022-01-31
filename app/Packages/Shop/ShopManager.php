<?php


namespace App\Packages\Shop;


use App\Models\Coupon;
use App\Models\DeliveryCharge;
use App\Models\Order;
use App\Models\UserCoupon;
use App\Packages\Shop\Contracts\CartInterface;

class ShopManager implements CartInterface
{
    public int $deliveryChargeId, $orderId;
    public $couponIdentifier;
    public $order = null, $orderItems = null, $walletObject, $couponObject, $previousOrder, $cashbackAmount;
    public $coupon = 0;
    public bool $shouldApplyCoupon, $couponCashBack = false;
    public float $couponReducedAmount = 0.0, $orderAmount = 0.0, $discount = 0, $walletReductionAmount = 0.0, $deliveryChargeAmount = 0.0;

    public function __construct($orderId, $couponIdentifier = null)
    {
        $this->orderId          =$orderId;
        $this->couponIdentifier = $couponIdentifier;

        $this->FindOrder();

        $this->walletObject = new WalletLoggedInUser(auth()->user(), $this->order);
        $this->couponObject = new Coupon();

    }

    public function FindOrder()
    {
        if($this->orderId != null)
        {
            $this->order = Order::with('orderItems.product', 'deliveryCharge', 'user')->findOrFail($this->orderId);
            $this->orderItems = $this->order->orderItems;
        }

    }

    public function FindCouponIdentifier()
    {
        return $this->couponIdentifier;
    }

    public function CalculateOrderFields()
    {
        $this->calculateCurrentAmountProducts();

        $this->getOrderDeliveryCharge();

        $this->ApplyCoupon();

        $this->orderAmount = $this->orderAmount + $this->deliveryChargeAmount;

        $this->ApplicableWalletAmount();

    }

    public function previousTaskBeforeUpdate():void
    {

    }

    public function getFieldsToUpdate()
    {
        return [
            'amount' => $this->orderAmount,
            'total_saved' => $this->discount,
            'delivery_charge' => $this->deliveryChargeAmount,
            'delivery_charge_id' => $this->deliveryChargeId,
            'coupon_id' => $this->coupon['id'],
            'wallet_reduction' => $this->walletReductionAmount,
            'cash_back' => $this->cashbackAmount
        ];
    }

    public function UpdateOrderAmount()
    {
       $this->CalculateOrderFields();

       $this->previousTaskBeforeUpdate();

       $fieldsToUpdate = $this->getFieldsToUpdate();

        if ($this->order->update($fieldsToUpdate))
        {
            return $this->tasksAfterOrderAmountUpdate();
        }
        return 0;
    }


    public function tasksAfterOrderAmountUpdate(): float
    {
        $this->ApplyWallet();
        if($this->shouldApplyCoupon && $this->couponCashBack){
            $this->walletObject->SaveOrUpdateWallet($this->cashbackAmount);
        }
        return $this->GetNetOrderAmount();
    }

    public function GetNetOrderAmount()
    {
//        return $this->orderAmount - $this->walletReductionAmount;
        return $this->orderAmount - $this->couponReducedAmount - $this->walletReductionAmount;
    }

    public function ApplicableWalletAmount()
    {
        $amountToPay = $this->orderAmount - $this->couponReducedAmount;
        $requestedWalletReductionAmount = $this->order->wallet_reduction>$amountToPay?$amountToPay:$this->order->wallet_reduction;
        $this->walletReductionAmount = $this->walletObject->getUserWalletReductionAmount($requestedWalletReductionAmount);
    }

    public function ApplyWallet()
    {
        $this->walletObject->UpdateUserWallet($this->walletReductionAmount);

    }

    public function ApplyCoupon()
    {
        $coupon = $this->couponObject->CheckCoupon($this->FindCouponIdentifier(), $this->orderAmount, true);
        $shouldApplyCoupon = false;
        if (!empty($coupon) && $coupon['success']) {
            $shouldApplyCoupon = true;
        }
        $this->coupon = $coupon;
        $this->shouldApplyCoupon = $shouldApplyCoupon;

        if ($this->shouldApplyCoupon) {
            UserCoupon::where('user_id', auth()->id())->where('coupon_id', $this->couponIdentifier)->limit(1)->increment('frequency');
            if ($this->coupon['isDeliveryFree']) $this->deliveryChargeAmount = 0;
            $this->couponCashBack = $this->coupon['isCashBack'];
            $this->cashbackAmount = $this->couponCashBack?$this->coupon['reducedAmount']:0;
            $this->couponReducedAmount = !$this->couponCashBack?$this->coupon['reducedAmount']:0;
        }
    }




    public function calculateCurrentAmountProducts():array
    {
        $this->orderAmount = 0;
        $this->discount = 0;

        if($this->orderItems == null) return [$this->orderAmount, $this->discount];

        foreach ($this->orderItems as $item) {

            $this->orderAmount += (($item->product->price_en - $item->product->discount) * $item->quantity);

            if ($item->product->discount > 0 || $item->product->discount != null) {
                $this->discount += $item->product->discount * $item->quantity;
            }
        }

        return [$this->orderAmount, $this->discount];
    }


    public function getOrderDeliveryCharge()
    {
        $charge = DeliveryCharge::where('minimum_amount', '<=', $this->orderAmount)->where('maximum_amount', ">=", $this->orderAmount)->first();
        if (empty($charge)) {
            $charge = DeliveryCharge::select('id', 'charge_amount')->first();
        }

        $this->deliveryChargeId = $charge['id'];
        $this->deliveryChargeAmount = $charge['charge_amount'];
    }
}
