<?php


namespace App\Packages\Shop;


use App\Packages\Shop\Contracts\OrderItemOperationBuilder;

class OrderItemOperationAutomated extends OrderItemOperationBuilder
{
    public function add($balance, $totalBalance):array
    {
        /*
        * Rule 1: wallet balance will never excess customer total balance
        *
        * Assumption
        *
        * ReductionAmount can never be greater than orderAmount
        *
        * orderAmount = 500, reductionAmount =  0, wallet = 1000, newPayableAmount = 500 -  0 = 500, newPayableAmount <= Wallet; reduceFromWallet = newPayableAmount; newReductionAmount = reductionAmount+reduceFromWallet
        * orderAmount = 500, reductionAmount = 10, wallet = 1000, newPayableAmount = 500 - 10 = 490, newPayableAmount <= Wallet; reduceFromWallet = newPayableAmount; newReductionAmount = reductionAmount+reduceFromWallet
        *
        * orderAmount = 500, reductionAmount =  0, wallet =  500, newPayableAmount = 500 -  0 = 500, newPayableAmount <= Wallet; reduceFromWallet = newPayableAmount; newReductionAmount = reductionAmount+reduceFromWallet
        * orderAmount = 500, reductionAmount = 10, wallet =  500, newPayableAmount = 500 - 10 = 490, newPayableAmount >  Wallet; reduceFromWallet = wallet;           newReductionAmount = reductionAmount+reduceFromWallet
        *
        * orderAmount = 500, reductionAmount =  0, wallet =  400, newPayableAmount = 500 -  0 = 500, newPayableAmount >  Wallet; reduceFromWallet = wallet;           newReductionAmount = reductionAmount+reduceFromWallet
        * orderAmount = 500, reductionAmount = 10, wallet =  400, newPayableAmount = 500 - 10 = 490, newPayableAmount >  Wallet; reduceFromWallet = wallet;           newReductionAmount = reductionAmount+reduceFromWallet
        *
        * orderAmount = 500, reductionAmount =  0, wallet =    5, newPayableAmount = 500 -  0 = 500, newPayableAmount >  Wallet; reduceFromWallet = wallet;           newReductionAmount = reductionAmount+reduceFromWallet
        * orderAmount = 500, reductionAmount = 10, wallet =    5, newPayableAmount = 500 - 10 = 490, newPayableAmount >  Wallet; reduceFromWallet = wallet;           newReductionAmount = reductionAmount+reduceFromWallet
        *
        * orderAmount = 500, reductionAmount =  0, wallet =    0, newPayableAmount = 500 - 10 = 490, wallet = 0;                 reduceFromWallet = 0;                newReductionAmount = reductionAmount+reduceFromWallet
        * orderAmount = 500, reductionAmount = 10, wallet =    0, newPayableAmount = 500 - 10 = 490, wallet = 0;                 reduceFromWallet = 0;                newReductionAmount = reductionAmount+reduceFromWallet
        *
        *
        */
        $reduceFromWallet = 0;
        $newWalletReductionAmount = $this->manager->previousOrderReductionAmount;
        $newWalletBalance = $balance;
        $newPayableAmount = $this->manager->orderAmount - $this->manager->previousOrderReductionAmount;

        if ($balance > 0) {
            if ($newPayableAmount <= $balance) {
                $reduceFromWallet = $newPayableAmount;
            } elseif ($newPayableAmount > $balance) {
                $reduceFromWallet = $balance;
            }
        }

        $newWalletReductionAmount = $newWalletReductionAmount + $reduceFromWallet;
        $newWalletBalance = $newWalletBalance - $reduceFromWallet;

        $newTotalBalance = $newWalletReductionAmount + $newWalletBalance;
        if ($newTotalBalance == $totalBalance) return [$newWalletReductionAmount, $newWalletBalance];

        else {
            $this->manager->resetOperation();
            throw new \Exception('Wrong wallet calculation.');
        }

    }

    public function remove($balance, $totalBalance):array
    {
        //        $cashbackDifference = $this->manager->order->cash_back - $this->manager->previousCashBack;
//
//        if ($cashbackDifference < 0 && $balance < abs($cashbackDifference)) {
//            $message = 'Wallet does not have sufficient balance to reduce cashback';
//            $this->manager->resetOperation($message);
//            throw new \Exception($message);
//        }

        /*
         * Rule 1: wallet balance will never excess customer total balance
         *
         * Assumption
         *
         * ReductionAmount can be greater than orderAmount
         *
         * orderAmount = 500, reductionAmount =   0, wallet = 1000, newPayableAmount = 500 -   0 =  500, newPayableAmount <= wallet && newPayableAmount > 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount =  10, wallet = 1000, newPayableAmount = 500 -  10 =  490, newPayableAmount <= wallet && newPayableAmount > 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 500, wallet = 1000, newPayableAmount = 500 - 500 =  000, newPayableAmount == 0,                             reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 600, wallet = 1000, newPayableAmount = 500 - 600 = -100, newPayableAmount < wallet && newPayableAmount < 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         *
         * Identical with part 1::
         * orderAmount = 500, reductionAmount =   0, wallet =  600, newPayableAmount = 500 -   0 =  500, newPayableAmount <= wallet && newPayableAmount > 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount =  10, wallet =  600, newPayableAmount = 500 -  10 =  490, newPayableAmount <= wallet && newPayableAmount > 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 500, wallet =  600, newPayableAmount = 500 - 500 =  000, newPayableAmount == 0,                             reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 600, wallet =  600, newPayableAmount = 500 - 600 = -100, newPayableAmount < wallet && newPayableAmount < 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         *
         * orderAmount = 500, reductionAmount =   0, wallet =  500, newPayableAmount = 500 -   0 =  500, newPayableAmount <= wallet && newPayableAmount > 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount =  10, wallet =  500, newPayableAmount = 500 -  10 =  490, newPayableAmount <= wallet && newPayableAmount > 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 500, wallet =  500, newPayableAmount = 500 - 500 =  000, newPayableAmount == 0,                             reduceFromWallet = 0,                newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 600, wallet =  500, newPayableAmount = 500 - 600 = -100, newPayableAmount <= wallet && newPayableAmount < 0, reduceFromWallet = newPayableAmount, newReductionAmount = reductionAmount+reduceFromWallet
         *
         * orderAmount = 500, reductionAmount =   0, wallet =  10, newPayableAmount = 500 -   0 =  500, newPayableAmount > wallet && newPayableAmount > 0, reduceFromWallet = wallet,            newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount =  10, wallet =  10, newPayableAmount = 500 -  10 =  490, newPayableAmount > wallet && newPayableAmount > 0, reduceFromWallet = wallet,            newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 500, wallet =  10, newPayableAmount = 500 - 500 =  000, newPayableAmount == 0,                             reduceFromWallet = 0,                 newReductionAmount = reductionAmount+reduceFromWallet
         * orderAmount = 500, reductionAmount = 600, wallet =  10, newPayableAmount = 500 - 600 = -100, newPayableAmount < wallet && newPayableAmount < 0, reduceFromWallet = newPayableAmount,  newReductionAmount = reductionAmount+reduceFromWallet
         *
         *
         */

        $reduceFromWallet = 0;
        $newWalletReductionAmount = $this->manager->previousOrderReductionAmount;
        $newWalletBalance = $balance;
        $newPayableAmount = $this->manager->orderAmount - $this->manager->previousOrderReductionAmount;

        if ($newPayableAmount == 0) {
            return [$newWalletReductionAmount, $newWalletBalance];
        }

        if ($newPayableAmount <= $balance) {
            $reduceFromWallet = $newPayableAmount;
        } elseif ($newPayableAmount > $balance) {
            $reduceFromWallet = $balance;
        }

        $newWalletReductionAmount = $newWalletReductionAmount + $reduceFromWallet;
        $newWalletBalance = $newWalletBalance - $reduceFromWallet;

        $newTotalBalance = $newWalletReductionAmount + $newWalletBalance;
        if ($newTotalBalance == $totalBalance) return [$newWalletReductionAmount, $newWalletBalance];

        else {
            $this->manager->resetOperation();
            throw new \Exception('Wrong wallet calculation.');
        }

    }
}
