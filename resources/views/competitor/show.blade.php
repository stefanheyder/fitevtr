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
                {!! Form::open(['action' => ['ScoreController@destroy', $score->id], 'method' => 'DELETE', 'name' => 'post_' . md5($score->id . $score->created_at)]) !!}
                    {{ $score->formatted() }}
                    @auth
                        <a 
                            class="fa fa-remove" 
                            href="javascript:void(0)" 
                            title="delete" onclick="if (confirm('Löschen?')) { document.post_<?= md5($score->id . $score->created_at) ?>.submit(); } event.returnValue = false; return false;"
                        >
                        </a>
                    @endauth
                {!! Form::close() !!}
                </div>
            @endforeach
        </div>
        <br>
    @endforeach
@stop
