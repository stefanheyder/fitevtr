<a
    tabindex="0"
    href="#"
    data-toggle="popover"
    data-html="true"
    data-popover-content="#score{{$score->id}}popover"
>
    {{$score->amount}}
</a>

<div id="score{{$score->id}}popover" class="hidden" hidden>
    <div class="popover-body">
        {{ Form::model($score, ['route' => ['score.update', $score->id], 'method' => 'PUT']) }}
        <div class="form-group">
            <label for="amount">Gewicht</label>
            <input
                class="form-control"
                id="amount"
                name="amount"
                placeholder="Gewicht"
                value="{{$score->amount}}">
        </div>
        {{ Form::hidden('competitor_id', $score->competitor_id)}}
        {{ Form::hidden('workout_id', $score->workout_id)}}
        {{ Form::close()}}
        <a href="#" onclick="window.makeScoreInvalid({{$score->id}})" class="badge badge-pill badge-danger">Ungültig</a>
        <a href="#" onclick="window.makeScoreUndecided({{$score->id}})" class="badge badge-pill badge-secondary">Unentschieden</a>
        <a href="#" onclick="window.makeScoreValid({{$score->id}})" class="badge badge-pill badge-success">Gültig</a>
    </div>
</div>
