<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderAccepted;
use App\Events\OrderConfirmed;
use App\Listeners\AcceptedNotificationsListener;
use App\Listeners\ConfirmOrderListener;

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
            AcceptedNotificationsListener::class,
        ],
        OrderConfirmed::class => [
            ConfirmOrderListener::class,
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
