<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;

class FlightController extends Controller
{
    public function index() 
    {
        $flight = [];

        return View::make('flight/show', compact('flight'));
    }
}
