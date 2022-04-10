<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\Payment;
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
        $crypto = Payment::where('title', $this->order->payment)->firstOrFail()->crypto ? ' на адрес:' : ' по номеру карты:';
        $content = '';
        $url = '';
        if ($this->order->destination == 'TokenSale') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/dashboard/orders/'.$this->order->id);
            $content = "Заявка №" . $this->order->id . " на " . $this->order->dhb_amount . " DHB принята кипером. \nПереведите " . $this->order->amount . " " . $this->order->currency . " в " . $this->order->payment . $crypto . " \n" . $this->order->payment_details . "\nКак только заявка будет выполнена, вы получите уведомление.";
        }
        elseif ($this->order->destination == 'deposit') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/wallet/orders/'.$this->order->id);
            $content = "Заявка №" . $this->order->id . " на получение " . $this->order->amount . " " . $this->order->currency . " принята кипером. \nПереведите " . $this->order->amount . " " . $this->order->currency . " в " . $this->order->payment . $crypto . " \n" . $this->order->payment_details . "\nКак только заявка будет выполнена, вы получите уведомление.";
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
