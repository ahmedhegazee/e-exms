<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyingTerm extends Model
{
    protected $guarded=[];

    public function years()
    {
        return $this->belongsToMany(StudyingYear::class)->withPivot(['is_current','is_available','is_ended'])->withTimestamps();
    }

    public function scopeAvailableRegistration($query,$available)
    {
        return $query->where('is_available',$available);
    }
    public function scopeEndedTerm($query,$available)
    {
        return $query->where('is_ended',$available);
    }
    public function scopeCurrentTerm($query,$available)
    {
        return $query->where('is_current',$available);
    }
}
