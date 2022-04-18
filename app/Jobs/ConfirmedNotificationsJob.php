<?php

namespace App\Jobs;

use App\Events\OrderConfirmed;
use App\Models\Order;
use App\Models\User;
use App\Notifications\ConfirmOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

class ConfirmedNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Модель текущей заявки
     *
     * @var Order
     */
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param  Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $owner = User::where('uid', $this->order->user_uid)->first();
        if ($this->order->status == 'completed') {

            try {
                $owner->notify(new \App\Notifications\ConfirmOrder($this->order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }

            $message = \App\Models\Message::where('order_id', $this->order->id)->first();
            if ($message) {
                try {
                    $telegram = new Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
                    $telegram->editMessageText([
                        'chat_id' => $message->chat_id,
                        'message_id' => $message->message_id,
                        'text' => $message->message . PHP_EOL . '🏁 <b>Заявка выполнена</b>',
                        'parse_mode' => 'html',
                        'reply_markup' => NULL
                    ]);
                } catch (TelegramSDKException $e) {
                    report ($e);
                }
            }

            if ($this->order->destination == 'TokenSale') {
                // Отправка сообщения, если пользователь впервые купил токены
                if ($owner->orders()->where('status', 'completed')->where('destination', 'TokenSale')->get()->count() == 1) {
                    try {
                        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                        $telegram->sendPhoto([
                            'chat_id' => $owner->uid,
                            'photo' => InputFile::create(env('APP_URL')."/img/welcome.png"),
                            'caption' =>
                                '<b>На связи команда проекта DAHUB!</b>'
                                . PHP_EOL .
                                'Присоединяйся в наши паблики, чат и поддержку, чтобы всегда быть в курсе событий и иметь доступ ко всем материалам проекта.'
                                . PHP_EOL . PHP_EOL .
                                '⭐ <a href="https://t.me/DaHubBot">DAHUB Bot</a> – главный бот проекта. Авторизация на платформе, оповещения о заявках и их статусе. Рекомендуем поставить его в закреп для быстрого доступа к платформе и кошельку.'
                                . PHP_EOL .
                                '🕶 <a href="https://t.me/+Uydxy_Jmh-3Y_BUg">DAHUB for owners of DHB</a> – закрытый чат и информация для держателей DHB'
                                . PHP_EOL .
                                '📣 <a href="https://t.me/DA_HUB">DAHUB News</a> – новости проекта'
                                . PHP_EOL .
                                '🔍 <a href="https://t.me/DaHubExplorer">DAHUB Explorer</a> – обозреватель транзакций на платформе'
                                . PHP_EOL .
                                '💬 <a href="https://t.me/DaHubSupportBot?start=public">DaHubSupportBot</a> – служба поддержки проекта. По всем вопрос сюда;)'
                                . PHP_EOL . PHP_EOL .
                                'Мы за дружественную коммуникацию, пиши, задавай вопросы, делись инсайтами. Добро пожаловать в DAHUB DAO!',
                            'parse_mode' => 'html',
                        ]);
                    }
                    catch (CouldNotSendNotification $e) {
                        report ($e);
                    }
                }
            }
        }
        else $this->release(10);
    }
}
