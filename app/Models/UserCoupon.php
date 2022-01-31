<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = ['user_id','coupon_id','frequency'];

    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(  User::class, 'user_id');
    }
    public function coupon()
    {
        return $this->belongsTo(  Coupon::class, 'coupon_id');
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

    /****************************
     * Public Methods area
     *****************************/
}
