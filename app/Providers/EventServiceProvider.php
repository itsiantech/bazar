<?php

namespace App\Providers;

use App\Events\OrderSuccessEvent;
use App\Listeners\OrderNotifyToSlackSuccessfulOrder;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\OrderConfirmationListener;
use App\Listeners\OrderNotifyToAdminListener;
use App\Listeners\OrderNotifyToDashboardListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderSuccessEvent::class => [
            // OrderNotifyToSlackSuccessfulOrder::class,
            OrderNotifyToDashboardListener::class,
           OrderConfirmationListener::class,
//            OrderNotifyToAdminListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
