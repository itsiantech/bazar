<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    use CommonFunctions;
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'name',
        'code',
        'validity',
        'minimum_amount',
        'amount',
        'max_use',
        'is_percent',
        'is_cash_back',
        'is_free_delivery',
        ];
    protected $dates = ['validity'];
    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function userCoupons()
    {
        return $this->hasMany(UserCoupon::class,'coupon_id');
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

        $data['is_percent']=$this->GetCheckBoxValue($data,'is_percent');
        $data['is_cash_back']=$this->GetCheckBoxValue($data,'is_cash_back');
        $data['is_free_delivery']=$this->GetCheckBoxValue($data,'is_free_delivery');

        return $data;
    }
    public function FindCouponByCode($couponCode)
    {
        return Coupon::where('code',$couponCode)->first();
    }

    public function CheckCoupon($couponIdentifier,$amount, $byId = false, $shouldFrequencyCheck = false)
    {
        if(empty($couponIdentifier)) return $this->ReturnEmptyCoupon("Identifier did not find");


        if($byId) $coupon  = $this->find($couponIdentifier);
        else $coupon  = $this->FindCouponByCode($couponIdentifier);

        if($shouldFrequencyCheck){
            if($this->CheckFrequency($coupon) == 0){
                $message = "Coupon Usage Limit Reached";
                return $this->ReturnEmptyCoupon($message);
            }
        }

        $message="Invalid code";
        if($coupon) {

            if ($this->CheckValidity($coupon)) {

                if ($this->CheckAmountValidity($coupon, $amount)) {
                    return [
                        'id' => $coupon->id,
                        'success' => true,
                        'message' => 'Coupon applied',
                        'reducedAmount' => $this->percentToNumber($coupon, $amount),
                        'isDeliveryFree'=> (bool) $coupon->is_free_delivery,
                        'isCashBack'=> (bool) $coupon->is_cash_back,
                    ];
                }

                $message = "This coupon is not applicable with this amount.";
                return $this->ReturnEmptyCoupon($message);
            }

            return $this->ReturnEmptyCoupon($message);
        }
        return $this->ReturnEmptyCoupon($message);
    }

    public function percentToNumber($coupon, $amount):float {

        if($coupon->is_percent == 0)
        {
            return (float)$coupon->amount;
        }
        return (float)($coupon->amount/100)*$amount;
//        return (($coupon->amount *  $amount) / 100);
    }
    public function ReturnEmptyCoupon($message)
    {
        return  $coupon=[
            'id' => null,
            'success'=> false,
            'message'=>$message,
            'reducedAmount' => 0
        ];
    }
    public function CheckValidity($coupon)
    {
        if($coupon->validity>=Carbon::today())
        {
            return true;
        }
        return false;
    }
    public function CheckAmountValidity($coupon,$amount)
    {

        if ($coupon->minimum_amount!=null && $coupon->minimum_amount!=0)
        {
            if($coupon->minimum_amount<$amount)
            {
                $reducedAmount = $this->percentToNumber($coupon, $amount);
                $originalAmount = $amount -  $reducedAmount;
                if($originalAmount < $coupon->minimum_amount) return false;
                return true;

            }
        }

        return false;
    }

    public function CheckFrequency($coupon)
    {
        $userId = Auth::user()->id;

        if(empty($coupon)) return 0;

        if ($coupon->max_use!=null)
        {
            $userCoupon = UserCoupon::where('user_id',$userId)->where('coupon_id',$coupon->id)->first();
            if ($userCoupon)
            {
                if ($userCoupon->frequency>=$coupon->max_use)
                {
                    return 0;
                }
                return 1;
            }
            return 2;

        }
        return 0;

    }


    /****************************
     * Public Methods area
     *****************************/
}
