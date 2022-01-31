<?php


namespace App\Packages\Gateway;


use App\Models\Order;
use App\Packages\Gateway\Base\BKASHBaseGateway;

class BKASHGateway extends BKASHBaseGateway
{
    public function processPayment(float $amount, Order $order): string
    {
        // TODO: Implement processPayment() method.

        return "";
    }

    public function ipnListener(array $transaction_data): bool
    {
        // TODO: Implement ipnListener() method.

        return true;
    }




}
