<?php

namespace App\Policies;

use App\Models\Bundle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BundlePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-category');
    }

    public function view(User $user, Bundle $model)
    {
        return $user->can('view-bundle');
    }


    public function create(User $user)
    {
        return $user->can('create-category');
    }


    public function update(User $user, Bundle $model)
    {
        return $user->can('edit-bundle');
    }


    public function delete(User $user, Bundle $model)
    {
        return $user->can('delete-bundle');
    }

    public function restore(User $user, Bundle $model)
    {
        return $user->can('view-bundle');
    }

    public function forceDelete(User $user, Bundle $model)
    {
        return $user->can('force-delete-bundle');
    }
}
