<?php

namespace App\Listeners;

use App\Events\OrderAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AcceptedNotificationsListener implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param OrderAccepted $event
     * @return void
     */
    public function handle(OrderAccepted $event)
    {
        dispatch(new \App\Jobs\AcceptedNotificationsJob($event->order));
    }
}
