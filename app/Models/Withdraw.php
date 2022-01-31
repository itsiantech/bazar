<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'user_id',
        'amount',
        'status',
    ];

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

    public function GetData($data)
    {
        return $data;
    }

    public function SaveWithdrawsInRefundController($orderId)
    {
        return $this->create($this->GetOrderData($orderId));
    }

    public function GetOrderData($refundId)
    {
        $refund = Refund::find($refundId);
        $withdrawData['user_id']=$refund->user_id;
        $withdrawData['amount']=$refund->amount;

        return $withdrawData;

    }

    /****************************
     * Public Methods area
     *****************************/
}
