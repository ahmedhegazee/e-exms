<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResultResource extends JsonResource
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
            'student_name'=>$this->student->user->full_name,
            'marks'=>$this->marks,
            'success'=>$this->success==0?'Failed':'Succeeded',

        ];
    }
}
