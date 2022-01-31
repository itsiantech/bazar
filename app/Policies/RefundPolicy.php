<?php

namespace App\Policies;

use App\Models\Refund;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefundPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-refund');
    }

    public function view(User $user, Refund $model)
    {
        return $user->can('view-refund');
    }


    public function create(User $user)
    {
        return $user->can('create-refund');
    }


    public function update(User $user, Refund $model)
    {
        return $user->can('edit-refund');
    }


    public function delete(User $user, Refund $model)
    {
        return $user->can('delete-refund');
    }

    public function restore(User $user, Refund $model)
    {
        return $user->can('view-refund');
    }

    public function forceDelete(User $user, Refund $model)
    {
        return $user->can('force-delete-refund');
    }
}
