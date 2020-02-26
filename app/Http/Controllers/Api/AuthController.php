<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Libraries\LoginManager;
use App\Http\Controllers\Api\ApiController;
use App\User;
use Validator;
use DB;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
    	$email = $request->email;
    	$password = $request->password;

    	$loginManager = new LoginManager();
        $loginUser = $loginManager->login( $email, $password );

        if( !$loginUser ){
        	return $this->respondErrorInDetails('Sorry! could not login.', $loginManager->getError());
        }

    	$res = $loginManager->complete( $request );

        $this->content['token'] = $res['content']['token'];

    	return response()->json(['data' => $this->content], $res['content']['status']);
    }

    public function logout(Request $request)
    {    
        Auth::user()->token()->revoke();

        return response()->json([
            'data' => [
                'message' => 'Successfully logged out'
            ]
        ]);
    }
}
