@extends('layouts.master')

@section('content')
<div class="row teamsheader mb-5 mt-3">
    <div class="col text-left">
        {{ $participants[0]->name }}
    </div>
    <div class="col text-center score">
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

<div class="row nextlift">
    <div class="col text-center">
        Nächste Hebung:
    </div>
</div>
<div class="row nextlift mb-2">
    <div class="col text-center">
        {{ $competition->nextUp()[0] }}
    </div>
</div>
<div class="row text-center">
    <div class="col nextstandingsheader">
    Wenn gültig:
    </div>
</div>
<div class="row text-center mb-5">
    <div class="col teamsheader score">
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
        {{ $nextUp[1] }}
    </div>

    <div class="col text-center">
        {{ $nextUp[2] }} +{{ $remainingLifts }} Hebungen
    </div>
</div>
@stop

@section('extraJS')
    <script>
        window.setInterval(function() {
    axios.get('/api/shouldUpdate', {
        params: {
            lastUpdate: timestamp
        }
    }).then(function(response) {
        if (response.data.update) {
            location.reload(true);
        }
    });
    }, 5000)
    </script>
@endsection
