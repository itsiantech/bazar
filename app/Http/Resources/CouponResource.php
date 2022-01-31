<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userCoupon = $this->UserCoupons->first();

        $frequency = null;

        if(!empty($userCoupon)) $frequency = $userCoupon->frequency;

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'code' => $this->code,
            'validity' => $this->validity,
            'minimum_amount' => $this->minimum_amount,
            'max_use' => $this->max_use,
            'is_percent' => $this->is_percent,
            'is_cashback' => $this->is_cash_back,
            'is_free_delivery' => $this->is_free_delivery,
            'couponFrequency' => $frequency
        ];
    }
}
