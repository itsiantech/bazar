<?php


namespace App\Http\View\Composers;

use Illuminate\View\View;

class NotificationComposer {

    public function compose(View $view) {

        $view('notifications', auth()->user()->unreadNotifications);
    }
}