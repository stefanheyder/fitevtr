<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    const TYPES = [
        'Landesliga',
        'Bundesliga'
    ];

    public function competitors()
    {
        return $this->belongsToMany('App\Competitor')->withPivot('competitive', 'weight');
    }

    public function workouts()
    {
        return $this->belongsToMany('App\Workout');
    }

    public function totalScore()
    {
        $workouts = $this->workouts;
        $first = $this->teams()[0];
        $second = $this->teams()[1];

        $firstPoints = $workouts->map(function($w) use($first) {
            return $this->score($first, $w);
        });
        $secondPoints = $workouts->map(function($w) use($second) {
            return $this->score($second, $w);
        });

        $firstTotal = $firstPoints->sum();
        $secondTotal = $secondPoints->sum();

        $didFirstWin = $firstPoints->zip($secondPoints)->map(function($x) {
            if (abs($x[0] - $x[1]) < 0.01) {
                return 1 / 2;
            }
            if ($x[0] > $x[1]) {
                return 1;
            }
            return 0;
        });


        $firstScore = $didFirstWin->sum() + ($firstTotal > $secondTotal);
        $secondScore = $workouts->count() + 1 - $firstScore;

        return $firstScore . ":" . $secondScore;
    }

    public function score($team, $workout)
    {
        return $this->competitors()
             ->get()
             ->where('pivot.competitive')
             ->where('team_id', $team->id)
             ->map(function($competitor) use($workout) {
                 return $this->singlePoints($competitor, $workout);
             })->sum();
    }

    public function scoreTotal($team)
    {
        $workouts = $this->workouts;

        return $workouts->map(function($w) use($team){
            return $this->score($team, $w);
        })->sum();
    }

    public function scoreTotalIfValid($team)
    {
        $workouts = $this->workouts;

        return $workouts->map(function($w) use($team){
            return $this->scoreIfNextValid($team, $w);
        })->sum();
    }


    public function singlePoints($c, $workout, $score = NULL)
    {
        if (is_null($score)) {
            $score = $c->bestScore($workout);
        }

        if($this->type == 'Landesliga') {
            # sinclair points
            $weight = $this->competitors->find($c->id)->pivot->weight;
            $s = Scoring::sinclairCoeff($weight, $c->gender);
            return $s * $score;
        } else if ($this->type == 'Bundesliga') {
            $weight = $this->competitors->find($c->id)->pivot->weight;
            $deds = Scoring::relative_deduction($weight, $c->gender);
            return max($score - $deds, 0);
        }
    }

    public function nextUp()
    {
        return $this->nextLifts()
                    ->map(function($s) {
                        return $s->competitor->name . "(" . $s->competitor->team->name .  "): " . $s->amount . ' kg'; #TODO: increment, number of attempt
                    })->values();
    }

    public function nextLifts()
    {
        $ongoingflights = $this->flights()
            ->get()
            ->reject(function($f) {
                return $f->finished();
            });

        if ($ongoingflights->isEmpty()) {
            return [];
        }
        return $ongoingflights->first()
                              ->scores()
                              ->where('validity', 'undecided')
                              ->sortBy(function($score) {
                                  $attempt = $score->attempt();
                                  $weight = $score->amount;
                                  return [$attempt, $weight];
                              });
    }

    public function totalScoreIfNextValid()
    {
        $nextLift = $this->nextLifts()->first();

        $workouts = $this->workouts;
        $first = $this->teams()[0];
        $second = $this->teams()[1];

        $firstPoints = $workouts->map(function($w) use($first) {
            return $this->scoreIfNextValid($first, $w);
        });
        $secondPoints = $workouts->map(function($w) use($second) {
            return $this->scoreIfNextValid($second, $w);
        });

        $didFirstWin = $firstPoints->zip($secondPoints)->map(function($x) {
            if (abs($x[0] - $x[1]) < 0.01) {
                return 1 / 2;
            }
            if ($x[0] > $x[1]) {
                return 1;
            }
            return 0;
        });

        $firstTotal = $firstPoints->sum();
        $secondTotal = $secondPoints->sum();

        $firstScore = $didFirstWin->sum() + ($firstTotal > $secondTotal);
        $secondScore = $workouts->count() + 1 - $firstScore;

        return $firstScore . ":" . $secondScore;
    }

    public function scoreIfNextValid($team, $workout)
    {
        $nextLift = $this->nextLifts()->first();

        $isSameWorkout = $workout->id == $nextLift->workout->id;
        $isSameTeam = $team->id == $nextLift->competitor->team_id;

        if ($isSameWorkout && $isSameTeam) {
            $competitor = $nextLift->competitor;

            return $this->score($team, $workout) + $this->singlePoints($competitor, $workout, $nextLift->amount); - $this->singlePoints($competitor, $workout);
        }
        return $this->score($team, $workout);
    }


    public function flights()
    {
        return $this->hasMany('App\Flight');
    }

    public function teams()
    {
        return $this->competitors()->get()
                                   ->pluck('team')
                                   ->unique()
                                   ->values();
    }
}
