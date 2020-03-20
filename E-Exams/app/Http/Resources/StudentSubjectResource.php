<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentSubjectResource extends JsonResource
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
            'name'=>$this->subject_name,
            'code'=>$this->subject_code,
            'credit_hours'=>$this->credit_hours,
            'professor'=>$this->professor->user->full_name,
            'questions'=>$this->chapters->map(function ($chapter){
                return $chapter->questions->count();
            })->sum(),
        ];
    }
}
