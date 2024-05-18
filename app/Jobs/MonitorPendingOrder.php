<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MonitorPendingOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;


    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (
            $this->order->status === OrderStatus::CANCELLED ||
            $this->order->status === OrderStatus::COMPLETED
        ) {
            return;
        }

        if ($this->order->olderThan(minutes : 1) || $this->attempts() > 3) {
            $this->order->markAsCanceled();

            return;
        }


        //send notification as email and sms

        $this->release(
            now()->addSeconds(20)
        );
    }
}
