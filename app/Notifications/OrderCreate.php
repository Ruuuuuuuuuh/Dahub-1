<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class OrderCreate extends Notification
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
        $url = '';
        $content = '';
        if ($this->order->destination == 'TokenSale') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/dashboard/orders/'.$this->order->id);
            $content = "Заявка №" . $this->order->id . " на получение " . $this->order->dhb_amount . " DHB успешно создана.\nОжидайте назначения кипера.";
        }
        elseif ($this->order->destination == 'deposit') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/wallet/orders/'.$this->order->id);
            $content = "Заявка №" . $this->order->id . " на получение " . $this->order->amount . " " . $this->order->currency . " успешно создана.\nОжидайте назначения кипера.";
        }
        elseif ($this->order->destination == 'withdraw') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/wallet/orders/'.$this->order->id);
            $content = "Заявка №" . $this->order->id . " на отправление " . $this->order->amount . " " . $this->order->currency . " успешно создана.\nОжидайте назначения кипера.";
        }

        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->uid)
            // Markdown supported.
            ->content($content)

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            ->button('Перейти в заявку', $url);
    }
}
