<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{

    const TYPES = [
        'AMRAP',
        'ForTime',
        '1RM'
    ];

    protected $fillable = [
        'name',
        'type'
    ];

    public function competitors()
    {
        return $this->hasManyThrough('App\Competitor', 'App\Score');
    }

    public function scores()
    {
        return $this->hasMany('App\Score');
    }
}
