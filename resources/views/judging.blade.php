@extends('layouts.master')

@section('title')
    Judging {{ $competitor->name }}
@stop

@section('content')
        <div class="row">
            <div class="col" style="text-align: center; font-size: 20px;">
                <b>{{ $workout->name }} ({{$workout->type}}) -- {{ $competitor->name }} </b>
            </div>
        </div>
        {{ Form::open(['url' => '/score', 'method' => 'POST']) }}
        <div class="row ">
                {{ Form::input("text", 'amount',  0, [ "style" => "font-size:80px;text-align:center;border-radius:10px;" . ($forTime? 'display:none' : ''), 'class' => 'col-12', 'autocomplete' => 'off', 'readonly' => $workout->type !== "1RM", 'id' => 'amount'])}}
                {{ Form::input($rm ? "hidden" : 'text', 'amountAsTime', '0:00', ['style' => 'font-size:80px;text-align:center;border-radius:10px;' . ($rm ? 'display:none' : ''), 'class' => 'col-12', 'readonly' => true, 'id' => 'amountAsTime'])}}
                {{ Form::input("hidden", 'workout_id', $workout->id, ["style" => 'display:none'])}}
                {{ Form::input("hidden", 'competitor_id', $competitor->id, ["style" => 'display:none'])}}
        </div>
        <div class="row {{$workout->type == '1RM' ? 'btn-group' : ''}}">
            @if($workout->type == '1RM')
                @foreach([2.5, 5, 10] as $increment)
                    <button type="button" class="btn btn-big btn-secondary col" onclick="document.getElementsByName('amount')[0].value = parseFloat(document.getElementsByName('amount')[0].value) + {{$increment}}">+ {{$increment}}</button>
                @endforeach
                <div class="w-100"></div>
                @foreach([20, 30, 40] as $increment)
                    <button type="button" class="btn btn-big btn-secondary col" onclick="document.getElementsByName('amount')[0].value = parseFloat(document.getElementsByName('amount')[0].value) + {{$increment}}">+ {{$increment}}</button>
                @endforeach
            @elseif($workout->type == 'AMRAP')
                <button type="button" class="btn btn-big btn-secondary col-12" onclick="document.getElementsByName('amount')[0].value = parseFloat(document.getElementsByName('amount')[0].value) + 1">+ 1</button>
                <br>

                <button type="button" name="startStop" class="btn btn-big btn-secondary col-12" onclick="startTimer(false, 240, false);"> Start </button>

                <br>

                <button type="button" class="btn btn-big btn-secondary col-12" onclick="document.getElementsByName('amount')[0].value = Math.max(parseFloat(document.getElementsByName('amount')[0].value) - 1, 0)">- 1</button>
            @else
                <button type="button" name="startStop" class="btn btn-big btn-secondary col-12" onclick="startTimer();"> Start </button>
            @endif
        </div>
        <div class="row">
            {{ Form::submit("Update", ["class" => "btn btn-big btn-success col-12", "style" => "font-size:80px;white-space:normal"] ) }}
        </div>
        {{ Form::close() }}
        <br>
        <div class="row">
            <a href="/" class="btn btn-big btn-primary col-12" style="font-size:80px;white-space:normal"> Zurück </a>
        </div>
        <br>
        <div class="row">
            <a href="/competitor/{{$competitor->id}}" class="btn btn-big btn-primary col-12" style="font-size:80px;white-space:normal"> Athlet </a>
        </div>

@stop
