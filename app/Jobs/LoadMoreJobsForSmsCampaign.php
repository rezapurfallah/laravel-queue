<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LoadMoreJobsForSmsCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $users)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $job = collect();
        foreach ($this->users as $user) {
            $job->push(new SendYaldaPromotionFormMailJob($user));
            $job->push(new SendYaldaPromotionFormSMSJob($user));
        }
        $this->batch()->add($job);
    }
}
