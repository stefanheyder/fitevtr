<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Score;

class ScoreController extends Controller
{
    public function update(Score $score) {
        $score->fill(request()->all('validity'));

        $score->save();
        return response()->json($score);
    }
}
