<?php

namespace App\Packages\Gateway\Contracts;

use App\Models\Order;

interface Gateway
{
    public function processPayment(float $amount, Order $order):string;

    public function ipnListener(array $transaction_data):bool;
}
