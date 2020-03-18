<?php

namespace App\Student;

use App\Department;
use App\Level;
use App\TrainingExam\TrainingExam;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=['user_id','academic_id'];

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
}
