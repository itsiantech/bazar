<?php


namespace App\Packages\Shop\Contracts;

abstract class OrderItemOperationBuilder
{
    public $manager;

    public function __construct(CartInterface $manager)
    {
        $this->manager = $manager;
    }

    abstract public function add($balance, $totalBalance):array;
    abstract public function remove($balance, $totalBalance):array;
}
