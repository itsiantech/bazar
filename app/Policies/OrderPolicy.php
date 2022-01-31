<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-order');
    }

    public function view(User $user, Order $model)
    {
        return $user->can('view-order');
    }


    public function create(User $user)
    {
        return $user->can('create-order');
    }

    public function discount(User $user)
    {
        return $user->can('discount-order');
    }


    public function update(User $user, Order $model)
    {
        return $user->can('edit-order');
    }


    public function delete(User $user, Order $model)
    {
        if(!$user->can('delete-order')) return $this->deny("You don't have permission to delete the order");

        $shouldTerminateOrder = $this->orderTerminateAdditionalRules($model, 'delete');

        if($shouldTerminateOrder instanceof Response) return $shouldTerminateOrder;

        return $user->can('delete-order') && $model->status == 'pending' && $model->wallet_reduction < 1 && $model->cash_back < 1;
    }

    private function orderTerminateAdditionalRules($model, $goal)
    {
        if($model->status != 'pending') return $this->deny("You can $goal order only in pending status");

        if(!($model->wallet_reduction < 1)) return $this->deny("This order is already using wallet");

        if(!($model->cash_back < 1)) return $this->deny("This order has cash back to wallet");

        return true;
    }

    public function restore(User $user, Order $model)
    {
        return $user->can('view-order');
    }

    public function forceDelete(User $user, Order $model)
    {
        return $user->can('force-delete-order');
    }
}
