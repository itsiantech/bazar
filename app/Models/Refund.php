<?php

namespace App\Models;

use App\Packages\Shop\OrderItemManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Refund extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'amount',
        'status',
        'discount',
        'quantity',
        'refunded_amount',
        'withdraw'
    ];

    private $refundOperation;


    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(  User::class, 'user_id');
    }

    /****************************
     * Public Methods area
     *****************************/

    /***
     * Method to get data.
     * @param $data
     * @return
     */

    public function GetData($orderId,$productId,$userId,$amount,$discount,$quantity)
    {
        $data['order_id']       = $orderId;
        $data['user_id']        = $userId;
        $data['product_id']     = (isset($productId)?$productId:null);
        $data['amount']         = $amount;
        $data['refunded_amount']= $this->getRefundedAmount();
        $data['discount']       = null;
        $data['quantity']       = $quantity;
        $data['status']         = 'accepted';
        //dd($data);
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/
    public function InitiateRefund($orderId, $orderItem):void
    {
        $this->refundOperation  = new OrderItemManager($orderId);

        $this->refundOperation->SetOperation('remove', $orderItem);

        $this->refundOperation->UpdateOrderAmount();
    }

    public function getRefundedAmount():float
    {
        if($this->refundOperation == null) return 0.0;

        return abs($this->refundOperation->extraAddedBalance);
    }

    public function GetRefundValues()
    {
        return DB::table('refunds')
            ->select('refunds.*','users.name','orders.unique_order_id')
            ->leftJoin('users','users.id','refunds.user_id')
            ->leftJoin('orders','orders.id','refunds.order_id')
            ->latest()
            ->get();
    }

    public function ChangeRefundStatus($id,$status)
    {
        return DB::table('refunds')->where('id',$id)->update(['status'=>$status]);
    }


}
