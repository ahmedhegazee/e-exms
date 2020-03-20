<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
        $correctAnswer=0;
        for($i=0;$i<sizeof($this->options->toArray());$i++){
            $options['option '.($i+1)]=$this->options[$i]->option_content;
           if($this->options[$i]->correct==1)
               $correctAnswer=$i;
        }
//        $options['correct answer']=$this->getCorrectAnswer($correctAnswer);
        $options['correct answer']=$correctAnswer+1;
        $question=[
            'question content'=>$this->question_content,
            'category'=>$this->category->category,
            'question type'=>$this->type->type,

        ];

        return array_merge($question,$options);
    }
}
