<?php

namespace App;

use App\Http\Resources\StudyingTermResource;
use Illuminate\Database\Eloquent\Model;

class StudyingYear extends Model
{
    protected $guarded=[];

    public function terms()
    {
       return $this->belongsToMany(StudyingTerm::class)->withPivot(['is_current','is_available','is_ended'])->withTimestamps();
    }
}
