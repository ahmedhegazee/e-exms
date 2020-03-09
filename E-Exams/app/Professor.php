<?php

namespace App;

use App\Subject\Subject;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
protected $fillable=['user_id','department_id'];
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
