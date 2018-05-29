<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'amount',
        'competitor_id',
        'workout_id'
    ];

    public function competitor()
    {
        return $this->belongsTo('App\Competitor');
    }

    public function workout()
    {
        return $this->belongsTo('App\Workout');
    }
}
