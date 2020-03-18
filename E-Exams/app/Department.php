<?php

namespace App;

use App\Subject\Subject;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded=[];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }

    public function level()
    {
        return $this->belongsToMany(Level::class);
    }
    public function scopeHasDept($query,$id)
    {
       return  $query->where('department_id',$id)->get();
    }
}
