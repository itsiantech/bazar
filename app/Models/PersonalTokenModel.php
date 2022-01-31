<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalTokenModel extends Model
{
    protected $table = "personal_access_tokens";

    public function user()
    {
        return $this->belongsTo(User::class, 'tokenable_id');
    }
}
