<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResultResource extends JsonResource
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
            'id'=>$this->exam->id,
            'date'=>$this->exam->start_time,
            'type'=>$this->getExamType($this->exam->exam_type),
            'score'=>$this->marks,
            'success'=>$this->success,
        ];
    }

    public function getExamType($type)
    {
        return [
            1=>'midterm exam',
            2=>'quiz',
            3=>'final exam'
        ][$type];
    }
}
