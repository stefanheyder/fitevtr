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

    public function powerliftingTotal()
    {
        $workouts = Workout::query()->where('type', '1RM')->get();

        return $workouts->map(function ($w) {
            $validScores = $this->scoresInWorkout($w)->where('validity', 'valid')->get();

            if ($validScores->isEmpty()) {
                return 0;
            }

            return $validScores->max('amount');
        })->sum();
    }

    public function powerliftingScores(Workout $workout) 
    {
        return $this->scoresInWorkout($workout)
                       ->get()
                       ->take(3)
                       ->pad(3, new Score(['amount' => 0, 'validity' => 'undecided']));

    }
}
