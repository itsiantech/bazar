<?php


namespace App\Packages\Shop\Contracts;


interface CartInterface
{

    public function FindOrder();
    public function FindCouponIdentifier();
    public function calculateCurrentAmountProducts();
    public function ApplicableWalletAmount();
    public function ApplyCoupon();
    public function getOrderDeliveryCharge();
    public function CalculateOrderFields();
    public function previousTaskBeforeUpdate();
    public function getFieldsToUpdate();
    public function UpdateOrderAmount();
    public function tasksAfterOrderAmountUpdate();
    public function ApplyWallet();
    public function GetNetOrderAmount();


}
