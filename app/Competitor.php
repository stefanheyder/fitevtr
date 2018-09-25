<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'weight'
    ];

    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    public function workouts()
    {
        return $this->belongsToMany('App\Workout', 'scores')->distinct();
    }

    public function scoresInWorkout(Workout $workout)
    {
        return $workout->scores()->where('competitor_id', $this->id);
    }

    public function bestScore(Workout $workout)
    {
        return $this->scoresInWorkout($workout)->orderBy('amount', $workout->sortOrder())->first()['amount'];
    }

    public function points(Workout $workout)
    {
        $competitors = $workout->competitors();
    }

    public function totalPoints()
    {
        $workouts = Workout::all();

        return $workouts ->map(function($w) {
            return $this->points($w);
        })->sum();
    }
}
