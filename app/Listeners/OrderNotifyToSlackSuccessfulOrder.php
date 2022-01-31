<?php

namespace App\Listeners;

use App\Notifications\OrderCreatedSlackNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderNotifyToSlackSuccessfulOrder
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
        // $event->order->slackChannel('notification.slack.order.created_channel')
        //     ->notify(new OrderCreatedSlackNotification($event->order));
    }
}
