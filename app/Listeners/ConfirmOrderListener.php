<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Jobs\ConfirmOrderJob;

class ConfirmOrderListener
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
     * @param OrderConfirmed $event
     * @return void
     */
    public function handle(OrderConfirmed $event)
    {
        dispatch(new ConfirmOrderJob($event->order));
    }
}
