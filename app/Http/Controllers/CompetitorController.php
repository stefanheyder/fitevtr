<?php

namespace App\Http\Controllers;

use App\Competitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class CompetitorController extends Controller
{
    /**
     * @param mixed 
     */
    public function __construct()
    {
        //$this->middleware('auth')->except(['index', 'show']);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('competitor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('competitor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->get('name') == "" || $request->get('weight') == "") {
            return Redirect::back();
        }
        $c = Competitor::create($request->all('name', 'gender', 'weight'));
        return Redirect::to('competitor/' . $c->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competitor  $competitor
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Competitor $competitor)
    {
        return View::make('competitor.show', compact('competitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competitor  $competitor
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Competitor $competitor)
    {
        return View::make('competitor.edit', compact('competitor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competitor  $competitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competitor $competitor)
    {
        $competitor->fill($request->all());
        $competitor->save();
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competitor  $competitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competitor $competitor)
    {
        $competitor->delete();
        return Redirect::back();
    }
}
