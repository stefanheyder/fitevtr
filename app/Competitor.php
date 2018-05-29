<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    protected $fillable = [
        'name',
        'gender'
    ];

    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    public function workouts()
    {
        return $this->hasManyThrough('App\Workout', 'App\Score');
    }
}
