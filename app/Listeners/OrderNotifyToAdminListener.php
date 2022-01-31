<?php

namespace App\Listeners;

use App\Mail\OrderNotifyToAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderNotifyToAdminListener implements ShouldQueue
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
        // Mail::to('admin@admin.com')->send(new OrderNotifyToAdminMail());
        Mail::to('asifulhaque086@gmail.com')->send(new OrderNotifyToAdminMail());
    }
}
