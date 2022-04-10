<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ConfirmOrder extends Notification
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
        $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/dashboard/');

        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->uid)
            // Markdown supported.
            ->content("Заявка №" . $this->order->id . " на получение " . $this->order->dhb_amount . " DHB выполнена.\nИстория и статус ваших заявок в разделе TokenSale 👉 «Мои заявки»")

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            ->button('Мои заявки', $url);
    }
}
