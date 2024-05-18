<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationEmailJob;
use App\Models\User;

class RegisterController extends Controller
{
    public function register()
    {
//        $validatedData = request()->validate([
//            'name' => 'required|min:3',
//            'email' => 'required|email|unique:users,email',
//            'password' => 'required|min:3',
//        ]);


//        $validatedData = [
//            'name' => 'reza',
//            'email' => 'reza@gmail.com',
//            'password' => '123456789'
//        ];

        $user = User::whereEmail('reza@gmail.com')->first();

        SendVerificationEmailJob::dispatch($user);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
