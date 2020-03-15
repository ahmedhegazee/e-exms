<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'subject'=>$this->subject->subject_name,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'exam_time'=>$this->exam_time,
            'marks'=>$this->marks,
        ];
    }
}
