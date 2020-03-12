<?php

namespace App\Student;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    protected $guarded=[];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
