<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class OrderAssignee extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $url = url('/wallet/');

        return TelegramMessage::create()
            ->to($notifiable->uid)
            ->content("Статус заявки №" . $this->order->id . " на получение " . $this->order->amount . " DHB изменен. Ожидайте подтверждения в течение 24 часов.")
            ->button('Перейти в кошелек', $url);
    }
}
