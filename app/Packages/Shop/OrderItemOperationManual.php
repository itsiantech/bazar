<?php


namespace App\Packages\Shop;


use App\Packages\Shop\Contracts\OrderItemOperationBuilder;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\Log;

class OrderItemOperationManual extends OrderItemOperationBuilder
{
    public function add($balance, $totalBalance):array
    {
        /*
        Rule 1: wallet balance will never excess customer total balance
        Rule 2: reductionAmount will always be previous reductionAmount No change

        Solve:
        $newWalletReductionAmount
        $reduceFromWallet
        $newWalletBalance

        Assumption
        orderAmount >> total product amount + delivery charge - couponReduction

        orderAmount = 500, reductionAmount = 000, wallet = 1000, $reduceFromWallet = 000; $newWalletReductionAmount = 000; $newWalletBalance = $wallet
        orderAmount = 500, reductionAmount = 010, wallet = 1000, $reduceFromWallet = 000; $newWalletReductionAmount = 010; $newWalletBalance = $wallet
        orderAmount = 500, reductionAmount = 300, wallet = 1000, $reduceFromWallet = 000; $newWalletReductionAmount = 300; $newWalletBalance = $wallet

        orderAmount = 500, reductionAmount = 000, wallet = 200, $reduceFromWallet = 000; $newWalletReductionAmount = 000; $newWalletBalance = $wallet
        orderAmount = 500, reductionAmount = 100, wallet = 200, $reduceFromWallet = 000; $newWalletReductionAmount = 100; $newWalletBalance = $wallet
        orderAmount = 500, reductionAmount = 200, wallet = 200, $reduceFromWallet = 000; $newWalletReductionAmount = 200; $newWalletBalance = $wallet

        orderAmount = 500, reductionAmount = 000, wallet = 000, $reduceFromWallet = 000; $newWalletReductionAmount = 000; $newWalletBalance = $wallet
        orderAmount = 500, reductionAmount = 100, wallet = 000, $reduceFromWallet = 000; $newWalletReductionAmount = 100; $newWalletBalance = $wallet
        orderAmount = 500, reductionAmount = 200, wallet = 000, $reduceFromWallet = 000; $newWalletReductionAmount = 200; $newWalletBalance = $wallet
        */


        $reduceFromWallet = 0;
        $newWalletReductionAmount = $this->manager->previousOrderReductionAmount;
        $newWalletBalance = $balance;

        $newTotalBalance = $newWalletReductionAmount + $newWalletBalance;
        if ($newTotalBalance == $totalBalance) return [$newWalletReductionAmount, $newWalletBalance];

        else {
            $this->manager->resetOperation();
            throw new \Exception('Wrong wallet calculation.');
        }

    }

    public function remove($balance, $totalBalance):array
    {

        /*
        Rule 1: wallet balance will never excess customer total balance


        Solve
        $reduceFromWallet
        $newWalletReductionAmount
        $newWalletBalance

        Assumption
        orderAmount : total product amount + delivery charge - couponReduction
        previousOrderAmount > orderAmount

        orderAmount = 500, reductionAmount = 000, wallet = 1000, previousOrderAmount = 600; $newWalletReductionAmount = 000,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 200, wallet = 1000, previousOrderAmount = 600; $newWalletReductionAmount = 200,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 500, wallet = 1000, previousOrderAmount = 600; $newWalletReductionAmount = 500,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 600, wallet = 1000, previousOrderAmount = 600; $newWalletReductionAmount = ordr_amn, $reduceFromWallet = 500 - 600 = -100

        orderAmount = 500, reductionAmount = 000, wallet = 0500, previousOrderAmount = 600; $newWalletReductionAmount = 000,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 200, wallet = 0500, previousOrderAmount = 600; $newWalletReductionAmount = 200,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 500, wallet = 0500, previousOrderAmount = 600; $newWalletReductionAmount = 500,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 600, wallet = 0500, previousOrderAmount = 600; $newWalletReductionAmount = ordr_amn, $reduceFromWallet = 500 - 600 = -100

        orderAmount = 500, reductionAmount = 000, wallet = 0300, previousOrderAmount = 600; $newWalletReductionAmount = 000,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 200, wallet = 0300, previousOrderAmount = 600; $newWalletReductionAmount = 200,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 500, wallet = 0300, previousOrderAmount = 600; $newWalletReductionAmount = 500,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 600, wallet = 0300, previousOrderAmount = 600; $newWalletReductionAmount = ordr_amn, $reduceFromWallet = 500 - 600 = -100

        orderAmount = 500, reductionAmount = 000, wallet = 0000, previousOrderAmount = 600; $newWalletReductionAmount = 000,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 200, wallet = 0000, previousOrderAmount = 600; $newWalletReductionAmount = 200,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 500, wallet = 0000, previousOrderAmount = 600; $newWalletReductionAmount = 500,      $reduceFromWallet = 000
        orderAmount = 500, reductionAmount = 600, wallet = 0000, previousOrderAmount = 600; $newWalletReductionAmount = ordr_amn, $reduceFromWallet = 500 - 600 = -100

         */
        $orderAmount = $this->manager->orderAmount;
        $previousOrderReductionAmount = $this->manager->previousOrderReductionAmount;

        $newWalletReductionAmount = $previousOrderReductionAmount;
        if($orderAmount < $newWalletReductionAmount) $newWalletReductionAmount = $orderAmount;

        $reduceFromWallet = 0;
        if($orderAmount < $previousOrderReductionAmount) $reduceFromWallet = $orderAmount - $previousOrderReductionAmount;

        $newWalletBalance = $balance;
        $newWalletBalance = $newWalletBalance - $reduceFromWallet;

        $newTotalBalance = $newWalletReductionAmount + $newWalletBalance;
        if ($newTotalBalance == $totalBalance) return [$newWalletReductionAmount, $newWalletBalance];
        else {
            Log::error('Newtotal Balance and previous total Balance mismatch', [
                '$orderAmount' => $orderAmount,
                '$previousOrderReductionAmount' => $previousOrderReductionAmount,
                'balance' => $balance,
                'newWalletBalance' => $newWalletBalance,
                'newTotalBalance' => $newTotalBalance,
                'totalBalance' => $totalBalance,
                '$newWalletReductionAmount' => $newWalletReductionAmount,
                '$reduceFromWallet' => $reduceFromWallet,

            ]);
            $this->manager->resetOperation();
            throw new \Exception('Wrong wallet calculation.');
        }

    }
}
