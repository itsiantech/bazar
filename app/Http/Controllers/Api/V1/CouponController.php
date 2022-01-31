<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $globalObject ;

    function __construct()
    {
        $this->globalObject = new Coupon();
    }
    public function CheckCoupon(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'amount' => 'array',
            'amount.payable' => 'required|int',
        ]);

        return response()->json($this->globalObject->CheckCoupon($request['code'],$request['amount']['payable'], false, true));
    }

    public function CouponDetails(Request $request)
    {
        $coupon = Coupon::with(['UserCoupons' => function($q){
            $q->where('user_id', auth()->id())->first();
        }])->where('code', $request->code)->whereNotNull('code')->first();

        if(!empty($coupon)) return new CouponResource($coupon);

        return [];
    }
}
