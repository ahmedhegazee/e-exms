<?php

namespace App\Student;

use App\Department;
use App\Level;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=['user_id','academic_id','level_id','department_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
