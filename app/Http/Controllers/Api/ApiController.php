<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response as IlluminateResponse;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $statusCode = 200;

    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function apiResponse($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function apiErrorResponse($message, $errorDetails = false)
    {
        if ($errorDetails) {

            $error['message'] = isset($errorDetails['message']) ? $errorDetails['message'] :  $message;

            if ($errorDetails['type'] == 'incorrect_password') {
                $error['errors']['password'][] = 'The password is invalid';
            }

            unset($error['errors']['type']);
        } else {
            $error['message'] = $message;
            $error['errors'] = null;
        }

        return $this->apiResponse( $error );
    }

    public function respondErrorInDetails($message, $errorDetails)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)->apiErrorResponse($message, $errorDetails);
    }
}
