<?php

namespace App\Http\Controllers;

use App\Jobs\SendWebhook;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{


    public function checkout()
    {


        $price = 10000;
        $order = null;
        DB::transaction(function () use (&$order, $price) {

//            $order = Order::create([
//                'user_id' => 5,
////                'status' => OrderStatus::PENDING,
//                'price' => $price,
//            ]);

//            auth()->user()->update([
//                'x' => 'y'
//            ]);
//
//            Payment::create([]);

        });


//        MonitorPendingOrder::dispatch($order)->delay(

//            now()->addSeconds(10)
//        );


        SendWebhook::dispatch('https://webhook.site/c4f43771-e1a9-46cb-b540', [
            'price' => 1000,
            'name' => 'reza purfallah'
        ]);

    }


}
