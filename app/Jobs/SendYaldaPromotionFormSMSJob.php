<?php

namespace App\Jobs;

use App\Channels\SmsChannel;
use App\Jobs\Middleware\SkipIfBachCancelled;
use App\Models\User;
use App\Notifications\YaldaPromotionNotification;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;
use Illuminate\Queue\SerializesModels;

class SendYaldaPromotionFormSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
//        $this->onQueue('promotion-sms');
    }

    public function middleware()
    {
        return [new SkipIfBatchCancelled];
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(3);
        try {
            $this->user->notify(new YaldaPromotionNotification(SmsChannel::class));
        } catch (Exception $e) {
            report($e);
            if ($this->attempts() < 3) {
                $this->release(10);
            }
        }
    }
}
