<?php

namespace App\Channels;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsChannel
{

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     */

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
//        $api_key = config('services.sms.api_key');
//        $phoneNumber = $notifiable->phone_number;

        try {
            Log::info('sms send!');
            $client = new Client();
//            $client->request('POST', "", [
//                'form_params' => [
//                    'receptor' => $phone_number,
//                    'message' => $message['text'],
//                ]
//            ]);
        } catch (Exception $e) {
            report($e);
        }
    }
}