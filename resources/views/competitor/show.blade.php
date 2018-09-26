@extends('layouts.master')

@section('title')
    Übersicht für {{ $competitor->name }}
@stop

@section('content')
    <h2>
        Übersicht für {{ $competitor->name }}
    </h2>
    @foreach(App\Workout::all() as $workout)
        <div class="list-group">
            @auth
                <a href="{{route('judge.workout', ['w' => $workout, 'c' => $competitor])}}" class="list-group-item">
                    {{ $workout->name }} ({{ $workout->type }})
                </a>
            @else
                <div class="list-group-item">
                    {{ $workout->name }} ({{ $workout->type }})
                </div>
            @endauth
            @foreach($competitor->scoresInWorkout($workout)->get() as $score)
                <div class="list-group-item">
                    <a href="/score/{{$score->id}}/edit">
                        {{ $score->formatted() }}
                    </a>
                </div>
            @endforeach
        </div>
        <br>
    @endforeach
@stop
