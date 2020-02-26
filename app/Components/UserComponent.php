<?php

namespace App\Components;

use App\Http\Requests\User\StoreRequest;
use App\User;

class UserComponent
{
    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $input['password'] = \Hash::make($input['password']);

        $user = User::create($input);

        return $user;
    }
}