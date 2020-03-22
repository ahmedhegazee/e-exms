<?php

namespace App;

use App\Subject\Chapter;
use App\Subject\Exam;
use Illuminate\Database\Eloquent\Model;

class ExamStructure extends Model
{
    protected $guarded=[];

    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
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
