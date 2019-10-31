<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    const TYPES = [
        'Landesliga'
    ];

    /**
     * undocumented function
     *
     * @return void
     */
    public function participants()
    {
        return $this->hasMany('App\Participant');
    }

}
