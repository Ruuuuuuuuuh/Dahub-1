<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class SendUserNotification extends Notification
{

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $message)
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
        return [\NotificationChannels\Telegram\TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return \NotificationChannels\Telegram\TelegramMessage::create()
            ->to($notifiable->uid)
            ->content($this->message);
    }
}
