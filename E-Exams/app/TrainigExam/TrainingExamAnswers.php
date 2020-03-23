<?php

namespace App\TrainingExam;

use App\Subject\Question;
use Illuminate\Database\Eloquent\Model;

class TrainingExamAnswers extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function exam()
    {
        return $this->belongsTo(TrainingExam::class, 'training_exam_id');
    }

    public function scopeExams($query, $exams)
    {
        return $query->whereIn('training_exam_id', $exams);
    }

    public function scopeWrongAnswers($query)
    {
        return $query->where('correct', 0);
    }
}
