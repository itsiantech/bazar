<?php


namespace App\Packages\Shop;


use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderItemManager extends ShopManager
{
    public string $operationType = 'add';

    public ?int $user_id = null;

    public $excessOrderAmount = 0.0, $previousOrderAmount = 0.0, $excessUserWallet = 0.0, $previousOrderReductionAmount = 0.0, $excessWalletAmount = 0.0, $previousCashBack = 0.0, $previousBalance = 0.0, $extraAddedBalance = 0;

    public $interestOrderItem;


    public function __construct($orderId, $couponIdentifier = null)
    {
        parent::__construct($orderId, $couponIdentifier);

        $this->user_id = $this->order ? $this->order->user_id : null;

        $this->walletObject = new OrderItemWalletManger($this->user_id, $this->order);

        $this->orderObject = new Order();
    }



    public function ApplicableWalletAmount()
    {
        $this->walletReductionAmount = $this->order->wallet_reduction;
        $this->excessWalletAmount = 0;

    }


    public function ApplyWallet()
    {

        $operation = 'sub';

        if ($this->operationType == 'add') {
            $operation = 'sub';
        } else {
            if ($this->excessWalletAmount >= 0) $operation = 'add';
            if ($this->excessWalletAmount < 0) $operation = 'sub';
        }

        if ($this->excessWalletAmount != 0)
            $this->walletObject->SaveOrUpdateWallet($this->excessWalletAmount, $operation);
    }


    public function applyNewWalletData(array $newData)
    {
        $walletNewReductionAmount = $newData[0];
        $walletNewBalance = $newData[1] + $this->order->cash_back;
        $this->extraAddedBalance = $walletNewBalance - $this->previousBalance;

        $this->order->update([
            'wallet_reduction' => $walletNewReductionAmount,
        ]);

        if(!empty($this->order->user)) {
            $wallet = $this->order->user->wallet()->updateOrCreate(['user_id' => $this->order->user_id],['balance' => $walletNewBalance]);
            $tran = $wallet->transactions()->create(['amount'=>$this->extraAddedBalance]);
        }
        else{
            throw new \Exception('User not found while updating user wallet');
        }

    }

    public function ComputeCustomerWalletAfterOrderUpdate()
    {
        $wallet = $this->walletObject->GetUserWallet();

        $this->previousCashBack = $this->previousOrder->cash_back;
        $this->orderAmount = $this->order->calculateOriginalAmountAfterDiscount();
        $this->previousOrderReductionAmount = $this->previousOrder->wallet_reduction;

        $this->previousBalance = $wallet->balance;
        $balance = $this->previousBalance - $this->previousOrder->cash_back;
        $totalBalance = $this->previousOrderReductionAmount + $balance;

        if ($this->operationType == 'add')
            $this->applyNewWalletData((new OrderItemOperationManual($this))->add($balance, $totalBalance));

        if ($this->operationType == 'remove')
            $this->applyNewWalletData((new OrderItemOperationManual($this))->remove($balance, $totalBalance));
    }


    public function FindCouponIdentifier()
    {
        return $this->order->coupon_id;
    }


    public function previousTaskBeforeUpdate(): void
    {
        $this->walletReductionAmount = $this->order->wallet_reduction;

        $this->previousOrder = json_decode(json_encode($this->order->toArray()));



        $wallet = $this->walletObject->GetUserWallet();

        if($this->previousOrder->cash_back > $wallet->balance)
        {
            $this->resetOperation();
            throw new \Exception('Order can not be updated because previous coupon cashback exceed wallet');
        }

    }


    public function resetOperation($message = null)
    {
        if ($this->operationType == 'add') $this->interestOrderItem->delete();

        else $this->order->orderItems()->create($this->interestOrderItem->toArray());

        if(!empty($this->previousOrder)){
            $fields = [
                'amount' => $this->previousOrder->amount,
                'wallet_reduction' => $this->previousOrder->wallet_reduction,
                'total_saved' => $this->previousOrder->total_saved,
                'cash_back' => $this->previousOrder->cash_back,
            ];

            $this->order->update($fields);
            return true;
        }

        throw new \Exception('Previous order found empty while resetting order'.($message != null)?"and ".$message:'');


    }



    public function SetOperation(string $operationType, $interestOrderItem)
    {

        $this->operationType = $operationType;

        $this->interestOrderItem = $interestOrderItem;

    }

    public function tasksAfterOrderAmountUpdate(): float
    {
        $this->ComputeCustomerWalletAfterOrderUpdate();
        return $this->GetNetOrderAmount();
    }

}
