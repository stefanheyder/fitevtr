<div class="container">
    <button type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-content="">
        {{$score->amount}}
    </button>
</div>

<div class="hidden" id="score{{$score->id}}popover">
    {{ Form::open(['action' => 'ScoreController@store'])}}
    <input type="text"> <button>Ok</button>
    {{ Form::hidden('competitor_id', $score->competitor_id)}}
    {{ Form::hidden('workout_id', $score->workout_id)}}
    {{ Form::submit('Ok', ['class' => 'btn btn-success']) }}
    {{ Form::close()}}
    <span onclick="changeScoreValidtiy({{$score->id}}, 'invalid')" class="badge badge-pill badge-danger">Ungültig</span>
    <span onclick="changeScoreValidtiy({{$score->id}}, 'undecided')" class="badge badge-pill badge-secondary">Unentschieden</span>
    <span onclick="changeScoreValidtiy({{$score->id}}, 'valid')" class="badge badge-pill badge-success">Gültig</span>">
</div>
