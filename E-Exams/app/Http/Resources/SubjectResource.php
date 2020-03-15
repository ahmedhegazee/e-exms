<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'name'=>$this->subject_name,
            'code'=>$this->subject_code,
            'level'=>$this->level->level_title,
            'department'=>$this->department->department_title,
            'credit_hours'=>$this->credit_hours,
            'professor'=>$this->professor->user->full_name,
            'term'=>$this->term==0?'first term':'second term',
        ];
    }
}
