<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    /**
     * undocumented function
     *
     * @return void
     */
    public function competitions()
    {
        return $this->hasMany('App\Competiton');
    }

    public function competitors()
    {
        return $this->hasMany('App\Competitor');
    }

    public function activeCompetitors()
    {
        return $this->hasMany('App\Competitor')
            ->where('noncompetetive', false);
    }


}
