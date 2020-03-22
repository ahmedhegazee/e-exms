<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamStructureResource extends JsonResource
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
            'chapter'=>$this->chapter->chapter_title,
            'questions'=>$this->questions_count,
            'category'=>$this->questionCategory->category,
            'questions type'=>$this->questionType->type
        ];
    }
}
