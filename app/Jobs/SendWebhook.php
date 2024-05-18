<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\RuntimeException;
use Throwable;

class SendWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 0;

    public $backoff = [60, 600, 3600];

    public $maxExceptions = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $url, public array $data) {}

    public function retryuntil()
    {
        return now()->addSeconds(40);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::post($this->url, $this->data);

        throw new RuntimeException('database disconnect');


        if ($response->failed()) {
            $this->release(
                now()->addSeconds(10 * $this->attempts())
            );
        }
    }

    public function failed(Throwable $exception)
    {
        //send email to a specific user
        Log::info('do something after send webhook field');
    }
}
