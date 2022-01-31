<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function getCreatedAtAttribute($createdAt)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format('d M, Y');
    }

    public function getUpdatedAtAttribute($createdAt)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format('d M, Y');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
