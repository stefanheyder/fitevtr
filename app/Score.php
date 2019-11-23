<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'amount',
        'competitor_id',
        'workout_id',
        'validity'
    ];

    public function competitor()
    {
        return $this->belongsTo('App\Competitor');
    }

    public function workout()
    {
        return $this->belongsTo('App\Workout');
    }

    public function formatted()
    {
        return $this->workout->formatScore($this->amount);
    }

    public function tableClassAttribute()
    {
        if ($this->validity == "valid") {
            return "table-success";
        }
        if ($this->validity == "invalid") {
            return "table-danger";
        }
        return "";
    }

    public function attempt()
    {
        $competitor = $this->competitor;
        $allScores = $competitor->scoresInWorkout($this->workout)->get();
        return $allScores->search(function($s) {
            return $s->id == $this->id;
        }) + 1;
    }

    public function nextAttempt()
    {
        $competitor = $this->competitor;
        $allScores = $competitor->scoresInWorkout($this->workout)->get();
        $currentIndex = $allScores->search(function($s) {
            return $s->id == $this->id;
        });

        if ($currentIndex + 1 < $allScores->count()) {
            return $allScores[$currentIndex + 1];
        }
        return null;
    }
}
