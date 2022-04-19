<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Экземпляр заявки.
     *
     * @var Order
     */
    public Order $order;

    /**
     * Создать новый экземпляр события.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
