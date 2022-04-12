<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CheckTonTransactionStatusJob implements ShouldQueue
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
        return now()->addHours(24);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $error = false;

        if ($this->order->status != 'completed') {
            try {
                // https://toncenter.com/api/v2/getTransactions?address=EQBiJUjSLIvFy0UAfxo0cWJvwT8XQcALpQjPCa6hJJMYltae&limit=30
                $response = Http::retry(3, 15)->get('https://toncenter.com/api/v2/getTransactions?address='.$this->order->payment_details.'&limit=5');
                if ($response->json()["result"]) {
                    foreach ($response->json()["result"] as $result) {
                        $amount = $result['in_msg']['value'] / 1000000000;
                        $utime = $result['utime'];
                        if ($utime > $this->order->created_at->timestamp) {
                            if ($this->order->amount <= $amount && $this->order->status != 'completed') {
                                dispatch(new ConfirmOrderJob($this->order));
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
        }
        if ($error) $this->release(33);
        else return true;

    }
}
