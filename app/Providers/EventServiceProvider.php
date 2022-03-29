<?php

namespace App\Providers;

use App\Notifications\ConfirmOrder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderAccepted;
use App\Events\OrderPending;
use App\Listeners\SendAcceptedNotifications;
use App\Listeners\ConfirmOrderListener;
use App\Listeners\SendConfirmedNotifications;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // ... other providers
            'SocialiteProviders\\Telegram\\TelegramExtendSocialite@handle',
        ],
        OrderAccepted::class => [
            SendAcceptedNotifications::class,
        ],
        OrderPending::class => [
            ConfirmOrderListener::class,
            SendConfirmedNotifications::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
