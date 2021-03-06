<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = parent::toArray($request);

        if (is_null($this->email_verified_at)) {
            $resource['email_verification_url'] = route('api.verify_email', $this->emailVerification->token);
        }

        $resource['favourite_companies'] = new CompanyCollection($this->favourite);

        return $resource;
    }
}
