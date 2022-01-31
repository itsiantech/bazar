<?php

namespace App\Policies;

use App\Models\DeliveryCharge;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryChargePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-delivery-charge');
    }

    public function view(User $user, DeliveryCharge $model)
    {
        return $user->can('view-delivery-charge');
    }


    public function create(User $user)
    {
        return $user->can('create-delivery-charge');
    }


    public function update(User $user, DeliveryCharge $model)
    {
        return $user->can('edit-delivery-charge');
    }


    public function delete(User $user, DeliveryCharge $model)
    {
        return $user->can('delete-delivery-charge');
    }

    public function restore(User $user, DeliveryCharge $model)
    {
        return $user->can('view-delivery-charge');
    }

    public function forceDelete(User $user, DeliveryCharge $model)
    {
        return $user->can('force-delete-delivery-charge');
    }
}
