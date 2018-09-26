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
        return $this->belongsToMany('App\Competitor', 'scores')->distinct();
    }

    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    public function sortOrder()
    {
        return $this->isForTime() ? 'asc' : 'desc';
    }

    /**
     * True if type is for time
     *
     * @return void
     */
    public function isForTime()
    {
        return $this->type == 'ForTime';
    }
    

    /**
     * Format score (e.g. AMRAP => Number, ForTime => Minute:seconds)
     *
     * @return void
     */
    public function formatScore($amount)
    {
        if (is_null($amount) ) {
            return "";
        }
        if ($this->isForTime()) {
            return gmdate("i:s", $amount);
        }

        return $amount;
    }

    public function powerliftingScores($flight)
    {
        return $flight
            ->competitors
            ->map(function($competitor) {
                return $competitor->powerliftingScores($this);
            });
    }

}
