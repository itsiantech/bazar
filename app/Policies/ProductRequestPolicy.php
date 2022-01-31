<?php

namespace App\Policies;

use App\Models\ProductRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-product-request');
    }

    public function view(User $user, ProductRequest $model)
    {
        return $user->can('view-product-request');
    }


    public function create(User $user)
    {
        return $user->can('create-product-request');
    }


    public function update(User $user, ProductRequest $model)
    {
        return $user->can('edit-product-request');
    }


    public function delete(User $user, ProductRequest $model)
    {
        return $user->can('delete-product-request');
    }

    public function restore(User $user, ProductRequest $model)
    {
        return $user->can('view-product-request');
    }

    public function forceDelete(User $user, ProductRequest $model)
    {
        return $user->can('force-delete-product-request');
    }
}
