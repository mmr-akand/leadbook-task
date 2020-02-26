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

        EmailVerification::create([
        	'email' => $input['email'],
        	'token' => str_random(32),
        	'expire' => date('Y-m-d H:i:s', strtotime('+1 day', time()))
        ]);

        return $user;
    }
}