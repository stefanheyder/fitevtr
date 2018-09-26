<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{

    public function competitors() 
    {
        return $this->belongsToMany('App\Competitor');
    }
}
