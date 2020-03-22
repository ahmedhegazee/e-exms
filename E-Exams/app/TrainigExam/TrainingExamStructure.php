<?php

namespace App\TrainingExam;

use App\QuestionCategory;
use App\QuestionType;
use App\Subject\Chapter;
use Illuminate\Database\Eloquent\Model;

class TrainingExamStructure extends Model
{
    protected $guarded=[];
    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class,'question_category_id');
    }
    public function exam()
    {
        return $this->belongsTo(TrainingExam::class);
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }
}
