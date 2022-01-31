<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view-slider');
    }

    public function view(User $user, Slider $slider)
    {
        return $user->can('view-slider');
    }


    public function create(User $user)
    {
        return $user->can('create-slider');
    }


    public function update(User $user, Slider $slider)
    {
        return $user->can('edit-slider');
    }


    public function delete(User $user, Slider $slider)
    {
        return $user->can('delete-slider');
    }

    public function restore(User $user, Slider $slider)
    {
        return $user->can('view-slider');
    }

    public function forceDelete(User $user, Slider $slider)
    {
        return $user->can('force-delete-slider');
    }
}
