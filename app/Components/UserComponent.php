<?php

namespace App\Components;

use App\Http\Requests\User\StoreRequest;
use App\EmailVerification;
use App\User;

class UserComponent
{
    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $input['password'] = \Hash::make($input['password']);

        $user = User::create($input);

        $verificationData = [
            'email' => $input['email'],
            'token' => str_random(32),
            'expire' => date('Y-m-d H:i:s', strtotime('+1 day', time()))
        ];
        
        if (!EmailVerification::where('email', $input['email'])->exists()) {            
            EmailVerification::create($verificationData);
        }

        return $user;
    }
}