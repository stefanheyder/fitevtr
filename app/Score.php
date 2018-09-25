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
}
