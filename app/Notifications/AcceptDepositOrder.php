<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AcceptDepositOrder extends Notification
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
        $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/wallet/orders/'.$this->order->id);

        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->uid)
            // Markdown supported.
            ->content("Заявка №" . $this->order->id . " на " . $this->order->dhb_amount . " DHB принята кипером. \nПереведите " . $this->order->amount . " " . $this->order->currency . " в " . $this->order->payment . " на адрес: \n" . $this->order->payment_details . "\nКак только заявка будет выполнена, вы получите уведомление.")


            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            ->button('Перейти в заявку', $url);
    }
}
