<?php

namespace App\Subject;

use App\ExamStructure;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded=[];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function structures()
    {
        return $this->hasMany(ExamStructure::class);
    }
}
