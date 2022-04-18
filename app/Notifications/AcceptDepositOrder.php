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
        $tonCoin = '';
        if ($this->order->destination == 'TokenSale') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/dashboard/orders/'.$this->order->id);
            $content = "Заявка #" . $this->order->id . " на получение " . $this->order->dhb_amount . " DHB принята кипером. \nПереведите " . $this->order->amount . " " . $this->order->currency . " в " . $this->order->payment . $crypto . " \n`" . $this->order->payment_details . "`\nКак только заявка будет выполнена, вы получите уведомление.";
        }
        elseif ($this->order->destination == 'deposit') {
            $url = url('/auth/'.$this->order->user()->first()->auth_token.'/?url=/wallet/orders/'.$this->order->id);
            $content = "Заявка #" . $this->order->id . " на получение " . $this->order->amount . " " . $this->order->currency . " принята кипером. \nПереведите " . $this->order->amount . " " . $this->order->currency . " в " . $this->order->payment . $crypto . " \n`" . $this->order->payment_details . "`\nКак только заявка будет выполнена, вы получите уведомление.";
        }
        if ($this->order->currency == 'TON') {
            $tonCoin = "ton://transfer/" . $this->order->payment_details . "?amount=" . ($this->order->amount * 1000000000) . "&text=" . $this->order->comment;
            if ($this->order->destination == 'TokenSale') {
                $content = "Заявка #" . $this->order->id . " на получение " . $this->order->dhb_amount . " DHB принята кипером. \n \n";
            }
            else {
                $content = "Заявка #" . $this->order->id . " на получение " . $this->order->amount . " " . $this->order->currency . " принята кипером. \n";
            }
            $content .=
                "Переведите `" . $this->order->amount . "` TON по следующим реквизитам: \n"
                . "Адрес: `" . $this->order->payment_details . "`\n"
                . "Примечание (мемо): `" . $this->order->comment . "`\n \n"
                . "При отправке средств укажите примечание (мемо). \n*ДЕПОЗИТ НЕ БУДЕТ ЗАЧИСЛЕН БЕЗ ПРИМЕЧАНИЯ!* \n \n"
                . "Как только средства будут зачислены, вы получите уведомление. Среднее время зачисления средств – одна минута.";

            return TelegramMessage::create()
                ->to($notifiable->uid)
                ->content($content)
                ->button('Открыть Toncoin кошелек', $tonCoin, 1)
                ->button('Перейти в заявку', $url, 1);
        }

        else return TelegramMessage::create()
            ->to($notifiable->uid)
            ->content($content)
            ->button('Перейти в заявку', $url);
    }
}
