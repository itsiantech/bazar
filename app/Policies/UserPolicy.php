<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-user');
    }

    public function view(User $user, User $model)
    {
        return $user->can('view-user');
    }


    public function create(User $user)
    {
        return $user->can('create-user');
    }


    public function update(User $user, User $model)
    {
        return $user->can('edit-user');
    }


    public function delete(User $user, User $model)
    {
        return $user->can('delete-user');
    }

    public function restore(User $user, User $model)
    {
        return $user->can('view-user');
    }

    public function forceDelete(User $user, User $model)
    {
        return $user->can('force-delete-user');
    }
}
