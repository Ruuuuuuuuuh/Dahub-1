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
        $referral = strpos('/start login', $text) === false ? '' : str_replace('/start login', '', $text);
        $username = isset($telegram_user['from']['username']) ? $telegram_user['from']['username'] : $telegram_user['from']['first_name'];
        $first_name = isset($telegram_user['from']['first_name']) ? $telegram_user['from']['first_name'] : '';
        $first_name .= isset($telegram_user['from']['last_name']) ? ' '.$telegram_user['from']['last_name'] : '';
        $user = array(
            'user_id'       => $telegram_user['from']['id'],
            'first_name'    => $first_name,
            'username'      => $username,
            'referred_by'   => $referral
        );
        $auth = new AuthController;
        $message = $auth->findOrCreateUser($user);
        $this->replyWithMessage(['text' => $message]);

/*      $response = Telegram::getUserProfilePhotos(['user_id' => $telegram_user['from']['id'], 'offset' => 0, 'limit' => 1]);
        $photos = $response->getPhotos();
        foreach ($photos[0] as $photo) {
            if ($photo['width'] == 320) {
                $this->replyWithMessage([ 'text' =>  $photo['file_id'] ]);
            }
        }

        https://api.telegram.org/file/bot1150126504:AAGHppcIXIcZ0pBmhx1mFQfZRfbfb-DPWWQ
        $this->replyWithMessage(['text' => json_encode($photos[0])]);*/

    }
}
