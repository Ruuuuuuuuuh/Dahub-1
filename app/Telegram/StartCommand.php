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
}
