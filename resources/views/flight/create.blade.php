@extends('layouts.master')

@section('content')
    <h2>
        Erstelle neuen Flight
    </h2>
    {{ Form::open(['url' => route('flight.store'), 'method' => 'POST']) }}
    <div class="form-group">
        <label for="title">Titel</label>
        <input type="text" value="" name="title" id="title" required class="form-control"/>
    </div>
    <div class="form-group">
        <label for="workouts[]">Lifts</label>
        <select name="workouts[]" id="workouts" multiple class="selectpicker form-control" data-live-search="true" data-actions-box="true" data-divider="true">
            @foreach(App\Workout::all() as $workout) 
                <option value="{{$workout->id}}" >
                {{ $workout->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="competitors[]">
            Teilnehmer
        </label>
        <select name="competitors[]" id="competitors" multiple  class="selectpicker form-control" data-live-search="true" data-actions-box="true" data-divider="true">
            @foreach(App\Competitor::all() as $competitor) 
                <option value="{{$competitor->id}}">
                {{ $competitor->name }}
                </option>
            @endforeach
        </select>
    </div>
    {{ Form::submit('Erstellen', ['class' => 'btn btn-success btn-big col']) }}
    {{ Form::close() }}

@stop
