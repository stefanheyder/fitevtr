@extends('layouts.master')

@section('content')
    {{ Form::model($competitor, ['route' => ['competitor.update', $competitor->id], 'method' => 'PUT']) }}
    <div class="form-group">
        <label for="name">Name</label>
        <input
            class="form-control"
            id="name"
            name="name"
            placeholder="Namen eingeben"
            value="{{$competitor->name}}">
    </div>
    <div class="form-group">
        <label for="gender">Geschlecht</label>
        <select class="form-control" id="gender" name="gender">
            <option value="male" {{$competitor->gender == "male" ? "selected" : ""}}>männlich</option>
            <option value="female" {{$competitor->gender == "female" ? "selected" : ""}}>weiblich</option>
        </select>
    </div>
    <div class="form-group">
        <label for="weight">Gewicht</label>
        <input
            class="form-control"
            id="weight"
            name="weight"
            placeholder="Gewicht"
            value="{{$competitor->weight}}">
    </div>
    {{ Form::submit('Update', ['class' => 'btn btn-success btn-big col']) }}
    {{ Form::close() }}
    {{ Form::model($competitor, ['route' => ['competitor.destroy', $competitor->id]]) }}
    {{ Form::submit('Löschen', ['class' => 'btn btn-warning btn-big col']) }}
    {{ Form::close() }}
@stop
