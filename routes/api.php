<?php

use Illuminate\Http\Request;
use App\Competitor;
use App\Score;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('shouldUpdate', function() {
    $comp = Competitor::query()->orderByDesc('updated_at')->first()->updated_at;
    $score = Score::query()->orderByDesc('updated_at')->first()->updated_at;

    $max = $comp->max($score);

    $wasThereAnUpdate = $max->gt(request()->lastUpdate);

    return response()->json(['update' => true]);
});
