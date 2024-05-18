<?php

use App\Http\Controllers\CampaignerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadVideoController;
use App\Jobs\ProcessVideo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ProcessVideo::dispatch();
    return 'jobs done';
});


Route::get('register', [RegisterController::class, 'register']);
Route::get('checkout', [CheckoutController::class, 'checkout']);
Route::get('upload/video', [UploadVideoController::class, 'upload']);
Route::get('campaign', [CampaignerController::class, 'sendCampaign']);
Route::get('/campaign/{batchId}/monitor', [CampaignerController::class, 'CampaignMonitor']);

