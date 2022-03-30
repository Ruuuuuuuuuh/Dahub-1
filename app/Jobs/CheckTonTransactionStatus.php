<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class CheckTonTransactionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Задать временной предел попыток выполнить задания.
     *
     * @return DateTime
     */
    public function retryUntil(): DateTime
    {
        return now()->addMinutes(15);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $error = false;

        try {
        // https://toncenter.com/api/v2/getTransactions?address=EQBiJUjSLIvFy0UAfxo0cWJvwT8XQcALpQjPCa6hJJMYltae&limit=30
            $response = Http::retry(3, 15)->get('https://toncenter.com/api/v2/getTransactions?address='.$this->order->payment_details.'&limit=5');
            if ($response->json()["result"]) {
                foreach ($response->json()["result"] as $result) {
                    $amount = $result['in_msg']['value'] / 100000000;
                    $utime = $result['utime'];
                    if ($utime > $this->order->updated_at->timestamp) {
                        if ($this->order->amount <= $amount) {
                            dispatch(new ConfirmOrder($this->order));
                        }
                        else $error = true;
                    }
                    else $error = true;
                }
            }
            else $error = true;
        }
        catch (HttpResponseException $e) {
            report ($e);
            $error = true;
        }

        if ($error) $this->release(15);


    }
}
