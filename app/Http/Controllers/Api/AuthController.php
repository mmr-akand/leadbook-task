<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\PasswordResetResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Libraries\AuthManager;
use App\Http\Controllers\Api\ApiController;
use App\User;
use App\PasswordReset;
use Validator;
use Uuid;
use DB;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
    	$email = $request->email;
    	$password = $request->password;

    	$authManager = new AuthManager();
        $loginUser = $authManager->login($email, $password);

        if (!$loginUser) {
        	return $this->respondErrorInDetails('Sorry! could not login.', $authManager->getError());
        }

    	$res = $authManager->complete($request);

        $this->content['token'] = $res['content']['token'];

    	return response()->json(['data' => $this->content], $res['content']['status']);
    }

    public function verifiyEmail($token)
    {    
        $authManager = new AuthManager();
        $verification = $authManager->verifiyEmail($token);

        if (!$verification) {
            return response()->json(['message' => 'Invalid Token'], 404);
        }

        return response()->json(['data' => 'Email Verified'], 200);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {    
        $authManager = new AuthManager();
        $response = $authManager->forgetPassword($request);

        return response()->json(['data' => $response], 200);
    }

    public function checkResetToken($token)
    {
        $authManager = new AuthManager();
        $reset = $authManager->checkResetToken($token, false);

        if (!$reset) {
            return response()->json(['message' => 'Invalid Token'], 404);
        }
            
        return new PasswordResetResource($reset);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $authManager = new AuthManager();
        $reset = $authManager->checkResetToken($request->token, $request->email);

        if (!$reset) {
            return response()->json(['message' => 'Invalid Token'], 404);
        }

        $user = $authManager->resetPassword($request);

        return new UserResource($user);
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
