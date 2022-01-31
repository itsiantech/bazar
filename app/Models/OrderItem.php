<?php

namespace App\Models;

use App\Packages\Shop\OrderItemManager;
use App\Packages\Shop\ShopManager;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    private $product, $walletObject, $couponObject, $orderItemObject;
    /****************************
     * Property area
     *****************************/
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    /****************************
     * Model Relation area
     *****************************/

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    /****************************
     * Public Methods area
     *****************************/

    /***
     * Method to get data.
     * @param $data
     * @return
     */

    public function GetData($data)
    {
        $data['price'] = $this->GetProductPrice($data['product_id']);
//        $data['discount'] = $this->GetProductDiscount($data['product_id']);


        return $data;
    }

    public function GetProduct($productId)
    {
        if (empty($this->product)) return Product::find($productId);

        return $this->product;

    }

    public function GetProductPrice($productId)
    {
        return $this->GetProduct($productId)->price_en;
    }

    public function UpdateOrderValue($request, $operation = "add", $orderItem = null)
    {

        $orderItemManager = new OrderItemManager($request->order_id);
        $orderItemManager->SetOperation($operation, $orderItem);
        $orderItemManager->UpdateOrderAmount();
        return 1;
    }

    private function UpdateOrderWalletUsage($order, $user, $previousWalletReduction)
    {
        $order = Order::find($order->id);

        $total = (new Order)->calculateOriginalAmountAfterDiscount($order);
//        dd($total);
        $walletReductionAmount = $this->walletObject->getUserWalletReductionAmount($total, $user);
        $order->update(['wallet_reduction' => $walletReductionAmount]);

        if ($walletReductionAmount < $previousWalletReduction)
            $this->walletObject->SaveOrUpdateWallet($order->user_id, $previousWalletReduction - $walletReductionAmount);

        if ($walletReductionAmount > $previousWalletReduction)
            $this->walletObject->SaveOrUpdateWallet($order->user_id, $walletReductionAmount - $previousWalletReduction, 'sub');


        return true;
    }



}
