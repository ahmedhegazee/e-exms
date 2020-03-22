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
        $exams=auth()->user()->student->trainingExams()->subject($this->id)->get();
        $passedExams =$exams->filter(function ($exam){
                if($exam->result->marks>=50)
                    return $exam;
            })->count();
        $failedExams=$exams->filter(function ($exam){
            if($exam->result->marks<50)
                return $exam;
        })->count();
        $correctAnswers=$exams->map(function($exam){
            return $exam->result->correct_answers;
        })->sum();
        $wrongAnswers=$exams->map(function($exam){
            return $exam->result->wrong_answers;
        })->sum();
        return [
            'id'=>$this->id,
            'name'=>$this->subject_name,
            'code'=>$this->subject_code,
            'credit_hours'=>$this->credit_hours,
            'professor'=>$this->professor->user->full_name,
            'questions'=>$this->chapters->map(function ($chapter){
                return $chapter->questions->count();
            })->sum(),
            'pass_exams'=>$passedExams,
            'failed_exams'=>$failedExams,
            'correct_answers'=>$correctAnswers,
            'wrong_answers'=>$wrongAnswers,
        ];
    }
}
