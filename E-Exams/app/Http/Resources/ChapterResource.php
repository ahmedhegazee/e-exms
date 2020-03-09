<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'title'=>$this->chapter_title,
            'subject name'=>$this->subject->subject_name,
            'subject code'=>$this->subject->subject_code,
            'questions'=>$this->questions->count(),
        ];
    }
}
