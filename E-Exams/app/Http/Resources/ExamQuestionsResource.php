<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $options=[];
        for($i=0;$i<sizeof($this->options->toArray());$i++){
            $options['option '.($i+1)]=$this->options[$i]->option_content;

        }
        $question=[
            'id'=>$this->id,
            'question content'=>$this->question_content,
            'type'=>$this->type->id
        ];

        return array_merge($question,$options);
    }
}
