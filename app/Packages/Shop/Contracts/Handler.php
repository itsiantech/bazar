<?php


namespace App\Packages\Shop\Contracts;


interface Handler
{
    public function handle(string $operation);
}
