<?php

namespace App\Packages\Wallet\Exceptions;


use Throwable;

class UserNotFound extends \Exception
{
    public function __construct($message = "Wallet User Not Found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
