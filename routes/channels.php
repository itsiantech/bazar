<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('OrderCreated', function ($user) {
    return $user->can('viewAny', \App\Models\Order::class);
});

Broadcast::channel('guest-room-{guest_id}', function ($user, $guest_id) {
    return true;
});
