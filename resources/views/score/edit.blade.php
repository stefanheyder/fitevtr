@extends('layouts.master')

@section('content')
    {{ Form::model($score, ['route' => ['score.update', $score->id], 'method' => 'PUT']) }}
    <div class="form-group">
        <label for="name">Workout</label>
        <div class="form-control">
            {{$score->workout->name}} ({{$score->workout->type}})
        </div>
    </div>
    <div class="form-group">
        <label for="validity">Gültigkeit</label>
        <select class="form-control" id="validity" name="validity">
            <option value="valid" {{ $score->validity == "valid" ? "selected" : ""}}> Gültig </option>
            <option value="undecided" {{ $score->validity == "undecided" ? "selected" : ""}}> Unentschieden</option>
            <option value="invalid" {{ $score->validity == "invalid" ? "selected" : ""}}> Ungültig</option>
        </select>
    </div>
    <div class="form-group">
        <label for="amount">Gewicht</label>
        <input
            class="form-control"
            id="amount"
            name="amount"
            placeholder="Gewicht"
            value="{{$score->amount}}">
    </div>
    {{ Form::submit('Update', ['class' => 'btn btn-success btn-big col']) }}
    {{ Form::close() }}
    {{ Form::model($score, ['route' => ['competitor.destroy', $score->id]]) }}
    {{ Form::submit('Löschen', ['class' => 'btn btn-warning btn-big col']) }}
    {{ Form::close() }}
@endsection
