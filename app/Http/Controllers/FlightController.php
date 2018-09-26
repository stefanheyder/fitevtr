<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;

use App\Flight;

class FlightController extends Controller
{
    public function index() 
    {
        $flights = Flight::all();

        return View::make('flight/index', compact('flights'));
    }

    public function show(Flight $flight) 
    {
        return View::make('flight/show', compact('flight'));
    }

}
