<?php

namespace App\Jobs;

use App\Mail\SendVerificationEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    public $backoff = [60, 60 * 10, 60 * 60];

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        $this->onQueue('sending-notification');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user)->send(new SendVerificationEmail($this->user));

    }
}
