<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingExamsAnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = new \DateTime($this->exam->created_at);
        $options = [];
        for ($i = 0; $i < $this->question->options->count(); $i++) {
            $options['option ' . ($i + 1)] = $this->question->options[$i]->option_content;
        }
        $question = [
            'id' => $this->id,
            'question' => $this->question->question_content,
            'type' => $this->question->question_type_id,
            'chapter' => $this->question->chapter->chapter_title,
            'exam date' => $date->format('d-m-Y h:i:sa'),
            'wrong answer' => $this->option_index,
            'correct answer'=>$this->question->correct_answer,
        ];

        return array_merge($question, ['options'=>$options]);
    }
}
