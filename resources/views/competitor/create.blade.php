@extends('layouts.master')
@section('content')
    {{ Form::open(['route' => 'competitor.store']) }}
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" id="name" aria-describedby="name" placeholder="Name" name="name">
    </div>
    <select class="custom-select" id="gender" name="gender">
        <option value="male" selected>Männlich</option>
        <option value="female">Weiblich</option>
    </select>
    <div class="form-group">
        <label for="weight">Gewicht</label>
        <input type="number" min="0" max="300" step="0.1" class="form-control" id="weight" aria-describedby="weight" placeholder="Gewicht" name="weight">
    </div>
    <button type="submit" class="btn btn-big btn-success col">Submit</button>
    {{ Form::close() }}
@stop
