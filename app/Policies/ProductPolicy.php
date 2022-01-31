<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-products');
    }

    public function view(User $user, Product $model)
    {
        return $user->can('view-products');
    }


    public function create(User $user)
    {
        return $user->can('create-products');
    }


    public function update(User $user, Product $model)
    {
        return $user->can('edit-products');
    }


    public function delete(User $user, Product $model)
    {
        return $user->can('delete-products');
    }

    public function restore(User $user, Product $model)
    {
        return $user->can('view-products');
    }

    public function forceDelete(User $user, Product $model)
    {
        return $user->can('force-delete-products');
    }
}
