<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $guarded=[];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }


}
