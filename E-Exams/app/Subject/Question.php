<?php

namespace App\Subject;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded=[];
    private $correctAnswers=[
        0=>'first option',
        1=>'second option',
        2=>'third option',
        3=>'fourth option',
        4=>'fifth option',
        5=>'sixth option',
    ];

    public function getCorrectAnswer($option)
    {
        return $this->correctAnswers[$option];
}
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

}
