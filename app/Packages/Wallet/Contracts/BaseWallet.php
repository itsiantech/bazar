<?php


namespace App\Packages\Wallet\Contracts;


interface BaseWallet
{

    public function GetData($userId,$balance=0);
    public function GetUserWallet();
    public function SaveOrUpdateWallet($amount,$operation="add");
    public function getWalletBalanceAfterOperation($balance,$amount,$operation);
    public function FindWalletByUserId($userId);
    public function UpdateWallet($wallet);
    public function UpdateUserWallet($walletReductionAmount, $user = null);
    public function getUserWalletReductionAmount(float $orderAmount):float;


}
