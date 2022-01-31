<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class Wallet extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'user_id',
        'balance',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'Y-m-d',
        'updated_at' => 'Y-m-d',
    ];

    public function getWalletIdAttribute()
    {
        return $this->user->customerId;
    }

    public function getTotalSpentAttribute()
    {
        $totalSpent = $this->transactions()->where('amount', '<', 0)->sum('amount');

        return abs($totalSpent);
    }
    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(  User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'wallet_id');
    }

    /****************************
     * Public Methods area
     *****************************/



    public function SaveOrUpdateWallet($amount = null, $operation="add"): bool
    {
        $result = false;

        $userId = $this->user->id;

        $wallet = $this->FindWalletByUserId($userId);

        if ($wallet)
        {

            $wallet->balance=$this->GetWalletBalance($wallet->balance,$amount,$operation);
            if ($this->UpdateWallet($wallet))
            {
                $result=true;
            }
        }
        else
        {
            if($this->create($this->GetData($userId,$amount)))
            {
                $result=true;
            }
        }

        return $result;

    }
}
