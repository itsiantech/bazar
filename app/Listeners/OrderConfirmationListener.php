<?php

namespace App\Listeners;

use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        // Mail::to(env('ORDER_TO_ADMIN_MAIL'))->send(new OrderConfirmationMail($event->order));
        // if($event->order->user->email) {
        //     Mail::to(env('ORDER_TO_ADMIN_MAIL'))->send(new OrderConfirmationMail($event->order));

        //     Mail::to($event->order->user->email)->send(new OrderConfirmationMail($event->order));
        // }
    }
}
