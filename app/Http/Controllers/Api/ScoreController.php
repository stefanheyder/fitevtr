<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Score;

class ScoreController extends Controller
{
    public function update(Score $score) {
        $score->fill(request()->all('validity'));

        $score->save();
        $nextAttempt = $score->nextAttempt();
        if (!is_null($nextAttempt)) {
            if ($score->validity == 'valid') {
                $nextAttempt->amount = $score->amount + ($score->attempt() == 1 ? 2 : 1);
                $nextAttempt->save();
            }
            else if ($score->validity == 'invalid') {
                $nextAttempt->amount = $score->amount;
                $nextAttempt->save();
            }
        }
        return response()->json($score);
    }
}
