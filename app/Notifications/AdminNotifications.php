<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AdminNotifications extends Notification
{
    use Queueable;

    protected $message;
    protected $username;

    /**
     * Create a new notification instance.
     *
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
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
        $url = url('/wallet/orders');
        return TelegramMessage::create()
            ->to($notifiable->uid)
            ->content($this->message)
            ->button('Смотреть список заявок', $url);
    }
}

