<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ReferralBonusPay extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
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
            // Optional recipient user id.
            ->to($notifiable->uid)
            // Markdown supported.
            ->content("Вам начислены реферальные бонусы в размере " . $this->order["amount"] . " " . $this->order["currency"] . ".")

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            ->button('Перейти в кошелек', $url);
    }
}
