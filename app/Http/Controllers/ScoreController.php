<?php

namespace App\Http\Controllers;

use App\Competitor;
use App\Score;
use App\Workout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $competitor = Competitor::find($request->get('competitor_id'));

        $workout = Workout::find($request->get('workout_id'));
        $isFemale = $competitor->gender == 'female';


        Score::create([
            'workout_id' => $request->get('workout_id'),
            'competitor_id' => $request->get('competitor_id'),
            'amount' => $request->get('amount')
        ]);

        return Redirect::to('/powerlifting');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function show(Score $score)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function edit(Score $score)
    {
        return View::make('score/edit')
            ->with('score', $score);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Score $score)
    {
        $score->fill($request->all());
        $score->save();
        return Redirect::to('judge/workout/'. $score->workout_id . '/competitor/' . $score->competitor_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        $score->delete();

        return Redirect()->back();
    }
}
