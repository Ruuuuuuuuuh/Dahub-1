<?php

namespace App\Listeners;

use App\Providers\OrderPending;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendConfirmedNotifications
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
     * @param  \App\Providers\OrderPending  $event
     * @return void
     */
    public function handle(OrderPending $event)
    {
        //
    }
}
