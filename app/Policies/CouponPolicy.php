<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-coupon');
    }

    public function view(User $user, Coupon $model)
    {
        return $user->can('view-coupon');
    }


    public function create(User $user)
    {
        return $user->can('create-coupon');
    }


    public function update(User $user, Coupon $model)
    {
        return $user->can('edit-coupon');
    }


    public function delete(User $user, Coupon $model)
    {
        return $user->can('delete-coupon');
    }

    public function restore(User $user, Coupon $model)
    {
        return $user->can('view-coupon');
    }

    public function forceDelete(User $user, Coupon $model)
    {
        return $user->can('force-delete-coupon');
    }
}
