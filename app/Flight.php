<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public function competitors()
    {
        return $this->belongsToMany('App\Competitor');
    }

    public function workouts()
    {
        return $this->belongsToMany('App\Workout');
    }

    public function competition()
    {
        return $this->belongsTo('App\Competition', 'competition_id');
    }

    public function scores()
    {
        return $this->competitors
                    ->pluck('scores')
                    ->flatten()
                    ->whereIn('workout_id', $this->workouts->pluck('id'));

    }

    public function finished()
    {
        return $this->scores()
            ->every(function($s) {
                return $s->validity == 'valid' || $s->validity == 'invalid';
            });
    }
}
