<?php

namespace App\Providers;

use App\Providers\OrderAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAcceptedNotifications
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
     * @param  \App\Providers\OrderAccepted  $event
     * @return void
     */
    public function handle(OrderAccepted $event)
    {
        //
    }
}
