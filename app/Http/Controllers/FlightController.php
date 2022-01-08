<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Flight;
use App\Workout;

class FlightController extends Controller
{
    public function index()
    {
        $flights = Flight::all();

        return View::make('flight/index', compact('flights'));
    }

    public function show(Flight $flight)
    {
        $currentLift = Workout::all()
            ->filter(function($workout) use($flight){
                return $workout
                    ->powerliftingScores($flight)
                    ->flatten()
                    ->contains('validity', 'undecided');
            })
            ->first();

        if (!$currentLift) {
            $currentLift = Workout::all()->last();
        }

        $currentAttempt = $currentLift
            ->powerliftingScores($flight)
            ->map(function($scores) {
                return $scores->filter(function($score) {
                    return $score->validity == "undecided";
                })->keys()->min();
            })->min() + 1;

        $orderedCompetitors = $flight
            ->competitors
            ->sortBy(function($competitor) use($currentLift, $currentAttempt){
                $scores = $competitor->powerliftingScores($currentLift);
                return $scores[$currentAttempt - 1]->amount;
            });
        $currentCompetitor = $orderedCompetitors
            ->filter(function($competitor) use($currentLift, $currentAttempt) {
                $scores = $competitor->powerliftingScores($currentLift);
                $currentScore = $scores[$currentAttempt -1];
                return $currentScore->validity == "undecided";
            })
            ->first();

        return View::make('flight/show')
            ->with('flight', $flight)
            ->with('currentCompetitor', $currentCompetitor)
            ->with('orderedCompetitors', $orderedCompetitors);
    }

    public function edit(Flight $flight)
    {
        return View::make('flight/edit')
            ->with('flight', $flight);
    }

    public function update(Request $request, Flight $flight)
    {

        $flight->competitors()->sync($request->competitors);
        $flight->workouts()->sync($request->workouts);

        $flight->save();

        return back();
    }

    public function create()
    {
        return View::make('flight/create');
    }

    public function store(Request $request)
    {
        $flight = new Flight();

        $flight->title = $request->title;
        $flight->save();
        $flight->competitors()->sync($request->competitors);
        $flight->workouts()->sync($request->workouts);

        $flight->save();
        return redirect(route('flight.show', $flight));
    }

    public function destroy(Flight $flight)
    {
        $flight->competitors()->detach();
        $flight->workouts()->detach();
        $flight->save();

        $flight->delete();

        return redirect('/');
    }
}
