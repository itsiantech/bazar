<?php


namespace App\Packages\Shop;


use App\Models\Order;
use App\Models\User;
use App\Packages\Wallet\WalletManager;
use Illuminate\Contracts\Auth\Authenticatable;

class WalletLoggedInUser extends WalletManager
{
    public function __construct(User $user, Order $order = null)
    {
        parent::__construct($user, $order);
    }

}
