<?php

namespace App\Subject;

use App\Student\Student;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $guarded=[];

    public function scopeExams($query,$exams)
    {
        return $query->whereIn('exam_id',$exams);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeFilterExam($query,$exam)
    {
        return $query->where('exam_id',$exam);
    }

    public function scopeFilterSubject($query,$subject)
    {
        return $query->where('subject_id',$subject);
    }

    public function scopeFailed($query)
    {
        return $query->where('success',0);
    }

    public function scopeSucceeded($query)
    {
        return $query->where('success',1);
    }
}
