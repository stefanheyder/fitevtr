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

}
