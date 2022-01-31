<?php


namespace App\Packages\Shop;


use App\Models\Order;
use App\Models\User;
use App\Packages\Shop\Contracts\OrderUpdate;
use App\Packages\Wallet\WalletManager;

class OrderItemWalletManger extends WalletManager implements OrderUpdate
{
    public ?object $user = null;

    public function __construct(?int $userId, Order $order)
    {
        $this->user = User::findOrFail($userId);

        parent::__construct($this->user, $order);

        $this->createEmptyWallet();
    }

    public function FindUser()
    {
        return $this->user;
    }
}
