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
        $count=$this->options->count();
        $randomNumbers=range(0,$count-1);
        shuffle($randomNumbers);

        $options=[];
        foreach ($randomNumbers as $index){
            array_push($options,$this->options[$index]->option_content);
        }
//        for($i=0;$i<sizeof($this->options->toArray());$i++){
//            $options['option '.($i+1)]=$this->options[$i]->option_content;
//
//        }
        return[
            'id'=>$this->id,
            'question content'=>$this->question_content,
            'type'=>$this->type->id,
            'options'=>$options
        ];
    }
}
