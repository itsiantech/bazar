<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use const http\Client\Curl\AUTH_ANY;
use App\Models\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'type','is_verified','otp','provider','provider_id', 'is_activated', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'otp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCustomerIdAttribute()
    {
        if($this->type != 'customer') return null;

        $joinedAt = $this->created_at;
        $name = Str::snake(Str::lower($this->name));
        return "{$joinedAt->format('M')}{$joinedAt->format('Y')}{$this->id}";
    }

    public function GetData($data)
    {
        $data['type'] = 'customer';
        $data['password'] = Hash::make($data['password']);
        $data['is_verified'] = 0;
        $data['is_activated'] = 1;
        return $data;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function GetUser()
    {
        return User::with('wallet')->find(Auth::user()->id);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function wishList()
    {
        return $this->hasMany(WishList::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }

    public function DeletedUser()
    {
        return $this->hasOne(UserDeleteRequest::class, 'user_id');
    }

    public function RestoreUser()
    {
        if($this->isDeleted())
        {
            return $this->DeletedUser->delete();
        }

        return false;
    }

    public function isDeleted()
    {
        $userDeletedData = $this->DeletedUser;

        if($userDeletedData) return true;

        return false;
    }

}
