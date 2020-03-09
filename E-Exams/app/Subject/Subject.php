<?php

namespace App\Subject;

use App\Department;
use App\Level;
use App\Professor;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded=[];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
