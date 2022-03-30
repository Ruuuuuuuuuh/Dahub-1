<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Events\OrderPending;
use App\Models\System;
use App\Models\User;
use App\Notifications\ConfirmOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class SendConfirmedNotifications
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderConfirmed  $event
     * @return void
     */
    public function handle(OrderConfirmed $event)
    {
        $owner = User::where('uid', $event->order->user_uid)->first();

        try {
            $owner->notify(new ConfirmOrder($event->order));
        } catch (CouldNotSendNotification $e) {
            report ($e);
        }

        if ($event->order->destination == 'TokenSale') {
            $transactions = $event->order->transactions();
            $telegram = new Api(env('TELEGRAM_BOT_EXPLORER_TOKEN'));
            foreach ($transactions as $transaction) {
                if ($transaction->payable_type == 'App\Models\System' && $transaction->type = 'withdraw') {
                    $event->order->transaction()->attach($transaction->id);
                    $systemWallet = System::findOrFail(1);
                    $systemWallet->getWallet('TokenSale')->refreshBalance();

                    try {
                        $telegram->sendMessage([
                            'chat_id' => env('TELEGRAM_EXPLORER_CHAT_ID'),
                            'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>↗️ Sent: </b>' . $event->order->amount . ' ' . $event->order->currency .PHP_EOL.'<b>↙️ Recieved: </b>' . $event->order->dhb_amount . ' DHB' .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid. PHP_EOL.PHP_EOL.'<b>🔥 TokenSale: </b>'. number_format($systemWallet->getWallet('TokenSale')->balanceFloat, 0, '.', ' ') . ' DHB left until the end of stage 1',
                            'parse_mode' => 'html'
                        ]);
                    } catch (CouldNotSendNotification $e) {
                        report ($e);
                    }

                }
            }
            // Отправка сообщения, если пользователь впервые купил токены
            if ($owner->orders()->where('status', 'completed')->where('destination', 'TokenSale')->get()->count() == 1) {
                try {
                    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                    $telegram->sendPhoto([
                        'chat_id' => $owner->uid,
                        'photo' => InputFile::create("https://test.dahub.app/img/welcome.png"),
                        'caption' =>
                            '<b>На связи команда проекта DaHub!</b>'
                            . PHP_EOL .
                            'Присоединяйся в наши паблики, чат и поддержку, чтобы всегда быть в курсе событий и иметь доступ ко всем материалам проекта.'
                            . PHP_EOL . PHP_EOL .
                            '▪️ <a href="https://t.me/+Uydxy_Jmh-3Y_BUg">Dahub for owners of DHB</a> – закрытый чат и информация для держателей DHB'
                            . PHP_EOL .
                            '▪️ <a href="https://t.me/DA_HUB">Dahub News</a> – новости проекта'
                            . PHP_EOL .
                            '▪️ <a href="https://t.me/DaHubExplorer">Dahub Explorer</a> – обозреватель транзакций на платформе'
                            . PHP_EOL .
                            '▪️ <a href="https://t.me/DaHubSupportBot?start=public">DaHubSupportBot</a> – служба поддержки проекта. По всем вопрос сюда;)'
                            . PHP_EOL . PHP_EOL .
                            'Мы за дружественную коммуникацию, пиши, задавай вопросы, делись инсайтами. Добро пожаловать в DaHub DAO!',
                        'parse_mode' => 'html',
                    ]);
                }
                catch (CouldNotSendNotification $e) {
                    report ($e);
                }
            }
        }
    }
}
