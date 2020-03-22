<?php

namespace App\Subject;

use App\QuestionCategory;
use App\QuestionType;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    private $correctAnswers = [
        0 => 'first option',
        1 => 'second option',
        2 => 'third option',
        3 => 'fourth option',
        4 => 'fifth option',
        5 => 'sixth option',
    ];

    public function getCorrectAnswer($option)
    {
        return $this->correctAnswers[$option];
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function type()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id');
    }

    public function scopeTypeMCQ($query)
    {
        return $query->where('question_type_id', 1);
    }

    public function scopeQuestionType($query, $type)
    {
        return $query->where('question_type_id', $type);
    }

    public function scopeTypeTrueOrFalse($query)
    {
        return $query->where('question_type_id', 2);
    }

    public function scopeQuestionCategory($query, $category)
    {
        return $query->where('question_category_id', $category);
    }

    public function scopeEasyQuestionCategory($query)
    {
        return $query->where('question_category_id', 1);
    }

    //medium
    public function scopeMediumQuestionCategory($query)
    {
        return $query->where('question_category_id', 2);
    }

    public function scopeDifficultQuestionCategory($query)
    {
        return $query->where('question_category_id', 3);
    }

    public static function getRandomQuestions($category, $type, $count)
    {
        return Question::questionCategory($category)->questionType($type)->get()->random($count);
    }
}
