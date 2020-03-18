<?php

namespace App\TrainingExam;

use App\Student\Student;
use App\Subject\Question;
use App\Subject\Subject;
use Illuminate\Database\Eloquent\Model;

class TrainingExam extends Model
{
    protected $guarded=[];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function result()
    {
        return $this->hasOne(TrainingExamResult::class);
    }

    public function answers()
    {
        return $this->hasMany(TrainingExamAnswers::class);
    }
    public function structures()
    {
        return $this->hasMany(TrainingExamStructure::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
