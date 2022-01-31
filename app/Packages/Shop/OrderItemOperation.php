<?php

use App\Packages\Shop\Contracts\Handler;
use App\Packages\Shop\Contracts\OrderItemOperationBuilder;

class OrderItemOperation implements Handler {

    private $operationType;

    public function __construct(OrderItemOperationBuilder $operationType)
    {
        $this->operationType = $operationType;
    }

    public function handle(string $operation)
    {
        return $this->operationType->$operation;
    }
}
