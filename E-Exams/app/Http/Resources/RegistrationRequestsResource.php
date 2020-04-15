<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationRequestsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'full_name'=>$this->full_name,
            'email'=>$this->email,
            'user_type'=>is_null($this->student)?"professor":"student",
            'verified'=>is_null($this->email_verified_at)?"not verified":'verified',
        ];
    }
}
