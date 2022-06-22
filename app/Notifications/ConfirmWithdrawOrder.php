<?php

namespace App\Notifications;

use App\Helpers\Rate;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ConfirmWithdrawOrder extends Notification
{
    use Queueable;

    protected Order $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Order $order)
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
        return [\NotificationChannels\Telegram\TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        if ($this->order->user_uid == $notifiable->uid) $content = "Заявка #" . $this->order->id . " на отправление " . $this->order->amount . ' ' . $this->order->currency . ' успешно выполнена!';
        else $content = "Заявка #" . $this->order->id . " на отправление " . $this->order->amount . ' ' . $this->order->currency . ' успешно выполнена!'.PHP_EOL.'Вам начислено ' . round($this->order->amount * Rate::getRates($this->order->currency) / 200 / Rate::getRates('DHB')) . ' DHB.';

        return \NotificationChannels\Telegram\TelegramMessage::create()
            ->to($notifiable->uid)
            ->content($content);
    }
}
