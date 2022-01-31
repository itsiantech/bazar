<?php

namespace App\Listeners;

use App\Events\SuccessfulOrderNotification;
use App\Notifications\OrderConfirmation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderNotifyToDashboardListener
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
        try{
            event(new SuccessfulOrderNotification($event->order));
        }catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
    }
}
