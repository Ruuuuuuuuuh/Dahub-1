<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $order_id
 * @property mixed $message_id
 * @property Message|mixed $message
 * @property mixed $chat_id
 * Модель сообщений с телеграм бота
 */
class Message extends Model
{
    use HasFactory;

    protected $guarded = [];
}
