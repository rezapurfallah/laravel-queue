<?php

namespace App\Http\Controllers;

use App\Jobs\SendYaldaPromotionFormMailJob;
use App\Jobs\SendYaldaPromotionFormSMSJob;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class CampaignerController extends Controller
{
    public function CampaignMonitor($batchId)
    {
        $batch = Bus::findBatch($batchId);
        return response()->json([
            'name' => $batch->name,
            'total_jobs' => $batch->totalJobs,
            'progress' => $batch->progress() . '%',
            'remind_jobs' => $batch->pendingJobs,
            'processed_jobs' => $batch->processedJobs(),
            'allows_fields' => $batch->allowsFailures(),
            'is_finished' => $batch->finished(),
            'is_cancelled' => $batch->cancelled(),
        ]);
    }

    public function sendCampaign()
    {
//        $campaign = Bus::findBatch('9c092514-b651-44b7-9595-69e8e46c78f2');
//        dd($campaign->cancel());
        $users = User::all();

        $job = collect();
        foreach ($users->take(5) as $user) {
            $job->push(new SendYaldaPromotionFormMailJob($user));
            $job->push(new SendYaldaPromotionFormSMSJob($user));
        }

//        $job->push(new LoadMoreJobsForSmsCampaign($users->skip(5)->take(5)));

        $batchData = Bus::batch([
            $job->toArray(),
        ])
            ->allowFailures()
            ->name('کمپین یلدا')
            ->onQueue('promotions')
            ->then(function (Batch $batch) {
                Log::info('all jobs run successfully');
            })
            ->catch(function (Batch $batch, Throwable $throwable) {
                Log::info('has error');
            })->finally(function (Batch $batch) {
                Log::info('this is batch finished');
            })
            ->dispatch();
        return $batchData;
    }
}
