<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyingPlan extends Model
{
    protected $guarded=[];
    protected $table='studying_term_studying_year';

    public function term()
    {
        return $this->belongsTo(StudyingTerm::class,'studying_term_id');
    }
    public function year()
    {
        return $this->belongsTo(StudyingYear::class,'studying_year_id');
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_current',1);
    }
    public function scopeAvailable($query)
    {
        return $query->where('is_available',1);
    }
}
