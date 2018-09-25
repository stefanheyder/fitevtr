@extends('layouts.master')
@section('content')
    {{ Form::open(['route' => 'competitor.store']) }}
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" id="name" aria-describedby="name" placeholder="Name" name="name">
    </div>
    <select class="custom-select" id="gender" name="gender">
        <option value="male" selected>Male</option>
        <option value="female">Female</option>
    </select>
    <button type="submit" class="btn btn-big btn-success col">Submit</button>
    {{ Form::close() }}
@stop
