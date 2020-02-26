<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Auth;
use App\EmailVerification;
use App\PasswordReset;
use App\User;
use Hash;

class AuthManager
{
	protected $user = null;
	protected $error;

	public function login($email, $password)
	{
		$cred_res = $this->checkCredentials($email, $password);
		if( $cred_res == false )
			return false;

		return $this->user->first();
	}

	private function checkCredentials($email, $password)
	{
		$user = User::where('email', $email);

		if (!Hash::check( $password, $user->first()->password)) {
	    	$this->error['message'] = 'The given data was invalid.';
			$this->error['type'] = 'incorrect_password';
			return false;
		}
		$this->user = $user;
		return true;
	}

    public function complete($request )
    {
    	Auth::attempt(['email' => request('email'), 'password' => request('password')]);
        $user = Auth::user();

        $personal_access_token_result = $user->createToken('leadbook token');
        $content['token'] =  $personal_access_token_result->accessToken;
        $content['status'] = 200;

        return compact('content');
    }

	public function getError()
	{
		return $this->error;
	}

	public function verifiyEmail($token)
	{
		$user = Auth::guard('api')->user();

		$verification = EmailVerification::where('token', $token)->where('expire', '>', date('Y-m-d H:i:s'))->where('email', $user->email)->first();

		if (is_null($verification)) {
			return false;
		}

		$user->email_verified_at = date('Y-m-d H:i:s');
		$user->save();

		EmailVerification::where('token', $token)->delete();

		return true;
	}

	public function checkResetToken($token, $email = false)
	{
		if ($email) {
			$reset = PasswordReset::where('token', $token)->where('expire', '>', date('Y-m-d H:i:s'))->where('email', $email)->first();
		} else {
			$reset = PasswordReset::where('token', $token)->where('expire', '>', date('Y-m-d H:i:s'))->first();
		}

		if (is_null($reset)) {
			return false;
		}

		return $reset;
	}

	public function forgetPassword($request)
	{		
        $email = $request->email;
        $reset = PasswordReset::where('email', $email)->first();

        if (!$reset) {
            $token = str_random(32);
            $expire = date('Y-m-d H:i:s', strtotime('+1 day', time()));

            $reset = PasswordReset::create(['email' => $email, 'token' => $token, 'expire' => $expire]);
        }

        $response = [
            'token' => $reset->token,
            'url' => route('api.check_reset_token', $reset->token)
        ];

		return $response;
	}

	public function resetPassword($request)
	{
        $user = User::where('email', $request->email)->first();

        $user->password = bcrypt($request->password);
        $user->save();

        PasswordReset::where('email', $request->email)->delete();
		
		return $user;
	}
}