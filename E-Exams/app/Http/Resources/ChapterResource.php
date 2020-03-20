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
//            'subject name'=>$this->subject->subject_name,
//            'subject code'=>$this->subject->subject_code,
            'questions'=>$this->questions->count(),
            'MCQ'=>[
                'A'=>$this->questions()->easyQuestionCategory()->typeMCQ()->count(),
                'B'=>$this->questions()->mediumQuestionCategory()->typeMCQ()->count(),
                'C'=>$this->questions()->difficultQuestionCategory()->typeMCQ()->count(),
            ],
            'T|F'=>[
                'A'=>$this->questions()->easyQuestionCategory()->typeTrueOrFalse()->count(),
                'B'=>$this->questions()->mediumQuestionCategory()->typeTrueOrFalse()->count(),
                'C'=>$this->questions()->difficultQuestionCategory()->typeTrueOrFalse()->count(),
            ]
        ];
    }
}
