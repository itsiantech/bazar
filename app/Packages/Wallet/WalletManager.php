<?php

namespace App\Packages\Wallet;

use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Packages\Shop\Contracts\OrderUpdate;
use App\Packages\Wallet\Contracts\BaseWallet;
use App\Packages\Wallet\Exceptions\UserNotFound;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class WalletManager implements BaseWallet
{
    public ?object $user = null;
    public ?object $order = null;

    public function __construct($user, Order $order = null)
    {
        if(empty($user)){
            throw new UserNotFound();
        }

        if(!($user instanceof Authenticatable||$user instanceof User))
        {
            throw new \Exception("Parameter expected Illuminate\\Contracts\\Auth\\Authenticatable or App\\Models\\User given ".get_class($user));
        }
        $this->user = $user;
        if (!empty($order)) $this->order = $order;
    }


    public function createEmptyWallet():object
    {
        return $this->user->wallet()->firstOrCreate(['user_id' => $this->user->id], ['balance' => 0, 'is_active' => 1]);
    }

    public function GetData($userId,$balance=0)
    {
        $data['user_id']= $userId;
        $data['is_active']= 1;
        $data['balance'] = $balance;
        return $data;
    }

    public function GetUserWallet()
    {
        return $this->findWallet();
    }

    public function withdrawFromUserWallet($amount):float
    {
        $wallet = $this->findWallet();

        $balance = $wallet->balance;

        $balanceDiff = $balance - $amount;

        if($balanceDiff > 0)
        {
            $this->SaveOrUpdateWallet($amount, 'sub');
            return $amount;
        }

        $this->SaveOrUpdateWallet($balance, 'sub');
        return $balance;

    }




    public function getWalletBalanceAfterOperation($balance,$amount,$operation)
    {
        return ($operation=='add'?($balance+$amount):($balance-$amount));
    }
    public function FindWalletByUserId($userId)
    {
        return Wallet::where('user_id',$userId)->whereNotNull('user_id')->first();
    }

    public function findWallet()
    {
        $wallet = $this->user->wallet()->first();

        if(!empty($wallet)) return $wallet;

        return $this->createEmptyWallet();
    }

    public function UpdateWallet($wallet)
    {
        return $wallet->update();
    }


    public function UpdateUserWallet($walletReductionAmount, $user = null)
    {
        if($walletReductionAmount < 1) return false;

        $user = $this->user;

        if(!empty($user) && $user->wallet()->decrement('balance', $walletReductionAmount))
        {
            $data = ['amount'=> (-1)*$walletReductionAmount];
            $wallet = $user->wallet;

            $this->createTransaction($data, $wallet);

            return true;
        }

        return false;
    }


    public function SaveOrUpdateWallet($amount = null, $operation="add"): bool
    {

        $wallet = $this->findWallet();

        $wallet->update(['balance' => $this->getWalletBalanceAfterOperation($wallet->balance,$amount,$operation)]);

        $data = ['amount' => $operation == 'add'?$amount:(-1)*$amount];

        $this->createTransaction($data, $wallet);

        return true;
    }

    public function createTransaction($data, $wallet = null)
    {
        if(empty($wallet)) $wallet = $this->findWallet();

        if (empty($this->order)) $wallet->transactions()->create($data);

        else {
            $data['wallet_id'] = $wallet->id;
            $this->order->transactions()->create($data);
        }
    }

    public function getUserWalletReductionAmount(float $orderAmount):float
    {

        $user = $this->user;

        $wallet = $user->wallet;

        $balance = empty($wallet)?0.0:$wallet->balance;

        if(!empty($wallet) && $balance > 0)
        {
            return $this->CompareWalletBalanceWithRequiredAmount($orderAmount, $balance);
        }

        return 0.00;
    }

    public function CompareWalletBalanceWithRequiredAmount($requiredAmount, $balance):float
    {
        if($balance == 0 || $balance < 0) return 0.0;

        if($requiredAmount == $balance) return $balance;

        if($requiredAmount > $balance) return $balance;

        if($requiredAmount < $balance) return $requiredAmount;

        return 0.0;
    }


}
