<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class TransactionService
{
    protected $user;

    public function __construct($user)
    {
        if(!($user instanceof User) || empty($user))
        {
            throw new \Exception('User Not Found Exception', 404);
        }

        $this->user = $user;
    }

    public function getHistory()
    {
        return $this->user->load(['transactions' => function($query){
            return $query->latest();
        }, 'wallet']);
    }

    public function getHisotoryOnly()
    {
        return $this->user->transactions()->latest();
    }
}
