<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideoJob;

class UploadVideoController extends Controller
{
    public function upload()
    {
        $file = request()->file('video');

        $file_path = '/storage/app/x.mp4';

        ConvertVideoJob::dispatch($file_path);
    }
}
