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

}
