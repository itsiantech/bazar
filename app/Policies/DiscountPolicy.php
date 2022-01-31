<?php

namespace App\Policies;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-discount');
    }

    public function view(User $user, Discount $model)
    {
        return $user->can('view-discount');
    }


    public function create(User $user)
    {
        return $user->can('create-discount');
    }


    public function update(User $user, Discount $model)
    {
        return $user->can('edit-discount');
    }


    public function delete(User $user, Discount $model)
    {
        return $user->can('delete-discount');
    }

    public function restore(User $user, Discount $model)
    {
        return $user->can('view-discount');
    }

    public function forceDelete(User $user, Discount $model)
    {
        return $user->can('force-delete-discount');
    }
}
