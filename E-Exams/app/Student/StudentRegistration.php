<?php

namespace App\Student;

use App\Department;
use App\Level;
use App\StudyingTerm;
use App\StudyingYear;
use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    protected $guarded=[];

    public function student()
    {
        return $this->belongsTo(Student::class);
    } public function level()
    {
        return $this->belongsTo(Level::class);
    } public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
