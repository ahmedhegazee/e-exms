<?php

namespace App\TrainingExam;

use Illuminate\Database\Eloquent\Model;

class TrainingExamResult extends Model
{
    protected $guarded=[];

    public function exam()
    {
        return $this->belongsTo(TrainingExam::class);
    }
}
