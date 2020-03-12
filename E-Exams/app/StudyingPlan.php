<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyingPlan extends Model
{
    protected $guarded=[];
    protected $table='studying_term_studying_year';

    public function term()
    {
        return $this->belongsTo(StudyingTerm::class);
    }
    public function year()
    {
        return $this->belongsTo(StudyingYear::class);
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
