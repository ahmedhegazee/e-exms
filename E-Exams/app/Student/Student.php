<?php

namespace App\Student;

use App\Department;
use App\ExamAnswer;
use App\ExamAttempt;
use App\Level;
use App\Subject\ExamResult;
use App\Subject\Subject;
use App\TrainingExam\TrainingExam;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'academic_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(StudentRegistration::class);
    }

    public function trainingExams()
    {
        return $this->hasMany(TrainingExam::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class);
}

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
}

    public function getSubjects()
    {
        $studentTerm = $this->registrations->last()->term;
        $studentDepartment = $this->registrations->last()->department->id;
        $studentLevel = $this->registrations->last()->level->id;
//       dd($studentDepartment);
        return Subject::currentTerm($studentTerm)->level($studentLevel)
            ->get()
            ->filter(function ($subject) use ($studentDepartment) {
            if ($subject->departments()->where('department_id', $studentDepartment)->count() > 0)
                return $subject;
        });
    }
}
