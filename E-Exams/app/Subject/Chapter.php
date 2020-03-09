<?php

namespace App\Subject;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
