@extends('layouts.master')

@section('content')
<div class="row teamsheader mb-5">
    <div class="col text-left">
        {{ $participants[0]->name }}
    </div>
    <div class="col text-center mx-auto">
        {{ $competition->totalScore() }}
    </div>
    <div class="col text-right">
        {{ $participants[1]->name }}
    </div>
</div>
@foreach($competition->workouts as $w)
<div class="row currentstandings">
    <div class="col text-left">
        {{ number_format($competition->score($participants[0], $w), 2)}}
    </div>
    <div class="col text-center">
        {{ $w->name }}
    </div>
    <div class="col text-right">
        {{ number_format($competition->score($participants[1], $w), 2)}}
    </div>
</div>
@endforeach
<div class="row currentstandings mb-5">
    <div class="col text-left">
        {{ number_format($competition->scoreTotal($participants[0]), 2)}}
    </div>
    <div class="col text-center">
        Gesamt
    </div>
    <div class="col text-right">
        {{ number_format($competition->scoreTotal($participants[1]), 2)}}
    </div>
</div>

<div class="row nextlift mb-5">
    <div class="col text-center">
        {{ $competition->nextUp()[0] }}
    </div>
</div>
<div class="row text-center">
    <div class="col nextstandingsheader">
    Wenn gültig:
    </div>
</div>
<div class="row text-center">
    <div class="col teamsheader">
        {{ $competition->totalScoreIfNextValid() }}
    </div>
</div>
@foreach($competition->workouts as $w)
    <div class="row nextstandings">
        <div class="col text-left">
            {{ number_format($competition->scoreIfNextValid($participants[0], $w), 2)}}
        </div>
        <div class="col text-center">
            {{ $w->name }}
        </div>
        <div class="col text-right">
            {{ number_format($competition->scoreIfNextValid($participants[1], $w), 2)}}
        </div>
    </div>
@endforeach
<div class="row nextstandings">
    <div class="col text-left">
        {{ number_format($competition->scoreTotalIfValid($participants[0]), 2)}}
    </div>
    <div class="col text-center">
        Gesamt
    </div>
    <div class="col text-right">
        {{ number_format($competition->scoreTotalIfValid($participants[1]), 2)}}
    </div>
</div>
<div class="row nextlifters text-center mt-5">
    <div class="col text-center">
        {{ $competition->nextUp()[1] }}
    </div>

    <div class="col text-center">
        {{ $competition->nextUp()[2] }} +{{ $competition->nextUp()->slice(3)->count() }} Hebungen
    </div>
</div>
@stop
