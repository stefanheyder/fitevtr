@extends('layouts.master')

@section('content')
    <h2>
        Übersicht für {{ $flight->title }} 
    </h2>
    {{ Form::model($flight, ['route' => ['flight.update', $flight->id], 'method' => 'PUT']) }}
        <div class="form-group">
            <label for="workouts[]">Lifts</label>
            <select name="workouts[]" id="workouts" multiple class="selectpicker form-control" data-live-search="true" data-actions-box="true" data-divider="true">
                @foreach(App\Workout::all() as $workout) 
                    <option value="{{$workout->id}}" {{ $flight->workouts->contains($workout) ? "selected" : ""}}>
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
                    <option value="{{$competitor->id}}" {{ $flight->competitors->contains($competitor) ? "selected" : ""}}>
                {{ $competitor->name }}
                    </option>
                @endforeach
            </select>
        </div>
    {{ Form::submit('Update', ['class' => 'btn btn-success btn-big col']) }}
    {{ Form::close() }}
@stop
