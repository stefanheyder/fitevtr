<?php

namespace App\Http\Controllers;

use App\Competitor;
use App\Workout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class JudgingController extends Controller
{
    public function startJudging(Workout $w, Competitor $c)
    {
        $forTime = $w->type == 'ForTime';
        $amrap = $w->type == 'AMRAP';
        $rm = $w->type == '1RM';

        return View::make('judging')
            ->with('workout', $w)
            ->with('competitor', $c)
            ->with('forTime', $forTime)
            ->with('rm', $rm)
            ->with('amrap', $amrap);
    }
}
