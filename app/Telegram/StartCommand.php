<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\AuthController;

/**
 * Class HelpCommand.
 */
class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';

    /**
     * @var string Command Description
     */
    protected $description = 'Команда Start, регистрация в боте';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $update = Telegram::getWebhookUpdates();
        $text = $update->getMessage()->getText();
        $telegram_user = Telegram::getWebhookUpdates()['message'];
        $referral = stripos('/start login', $text) === false ? str_replace('/start login', '', $text) : '';
        //str_replace('/start login', '', $text)
        $username = $telegram_user['from']['username'] ?? $telegram_user['from']['first_name'];
        $first_name = $telegram_user['from']['first_name'] ?? '';
        $first_name .= isset($telegram_user['from']['last_name']) ? ' '.$telegram_user['from']['last_name'] : '';
        $user = array(
            'user_id'       => $telegram_user['from']['id'],
            'first_name'    => $first_name,
            'username'      => $username,
            'referred_by'   => $referral
        );
        $auth = new AuthController;
        $message = $auth->findOrCreateUser($user);
        if ($message) {
            $inline_button = array(
                [
                    "text" => "Токенсейл🔥",
                    "url" => $message['linkDashboard']
                ],
                [
                    "text" => "Кошелёк",
                    "url" => $message['linkWallet']
                ]
            );
            $inline_keyboard = [$inline_button];
            $keyboard = array("inline_keyboard" => $inline_keyboard);
            $replyMarkup = json_encode($keyboard);
            $this->replyWithMessage([
                'text' => $message['text'],
                'parse_mode' => 'html',
                'reply_markup' => $replyMarkup
            ]);
        }
        else {
            $text = 'Приветствуем вас, '.$first_name.'!'.PHP_EOL.PHP_EOL
                .'К сожалению, мы не можем вас зарегистрировать в нашей системе. '.PHP_EOL
                .'Возможные причины:'.PHP_EOL.PHP_EOL
                .'– У вас нет ссылки на приглашение'.PHP_EOL
                .'– Ссылка на приглашение не действительна'.PHP_EOL
                .'– Пригласивший вас участник не является держателем DHB'.PHP_EOL.PHP_EOL
                .'По всем вопросам вы можете обратиться в @DaHubSupportBot';
            $this->replyWithMessage([
                'text' => $text,
                'parse_mode' => 'html',
                'reply_markup' => false
            ]);
        }

    }
}
