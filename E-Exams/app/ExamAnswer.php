<?php

namespace App;

use App\Student\Student;
use App\Subject\Exam;
use App\Subject\Question;
use App\Subject\QuestionOption;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function questionOption()
    {
        return $this->belongsTo(QuestionOption::class);
    }

    public function scopeFilterExam($query, $exam)
    {
        return $query->where('exam_id',$exam);
    }

    public function scopeFilterQuestion($query,$question)
    {
        return $query->where('question_id',$question);
    }
    public function scopeFilterQuestionOption($query,$option)
    {
        return $query->where('question_option_id',$option);
    }

    public function scopeCorrect($query)
    {
        return $query->where('correct',1);
    }

    public function scopeWrong($query)
    {
        return $query->where('correct',0);
    }
}
