<?php

namespace App\TrainingExam;

use App\Subject\Question;
use Illuminate\Database\Eloquent\Model;

class TrainingExamAnswers extends Model
{
    protected $guarded=[];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function exam()
    {
        return $this->belongsTo(TrainingExam::class,'training_exam_id');
    }

}
