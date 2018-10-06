<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::resource('competitor', 'CompetitorController');
Route::resource('score', 'ScoreController')
    ->middleware('auth');


Route::get('judge/workout/{w}/competitor/{c}', 'JudgingController@startJudging')
    ->name('judge.workout')
    ->middleware('auth');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')
    ->name('logout')
    ->middleware('auth');

Route::resource('flight', 'FlightController');

Route::view('powerlifting', 'competitor/powerliftingOverview');

Route::view('/', 'dashboard');
