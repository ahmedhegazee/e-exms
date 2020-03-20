<?php

namespace App;

use App\Subject\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
