<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Team;

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
        return $this->belongsToMany('App\Workout', 'scores')->distinct();
    }

    public function scoresInWorkout(Workout $workout)
    {
        return $workout->scores()->where('competitor_id', $this->id);
    }

    public function bestScore(Workout $workout)
    {
        return $this
            ->scoresInWorkout($workout)
            ->where('validity', 'valid')
            ->orderBy('amount', $workout->sortOrder())
            ->get()
            ->whenEmpty(function($c) {return $c->push(['amount' => 0]);})
            ->first()['amount'];
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

    public function powerliftingTotal(Flight $flight)
    {
        $workouts = $flight->workouts;

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
                       ->pad(3, new Score([
                               'amount' => 0,
                               'validity' => 'undecided',
                               'competitor_id' => $this->id,
                               'workout_id' => $workout->id
                           ]));

    }

    public function flight()
    {
        return $this->belongsToMany('App\Flight');
    }

    public function team()
    {
        return $this->belongsTo('App\Team', 'team_id');
    }


}
