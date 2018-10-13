
@if($score->id)
    <div data-toggle="modal" data-target="#score{{$score->id}}Modal">
        {{ $score->amount }}
    </div>
    <div class="modal fade" id="score{{$score->id}}Modal" tabindex="-1" role="dialog" aria-labelledby="score{{$score->id}}ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="score{{$score->id}}ModalLabel">Score bewerten</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="h2">
                        {{ $score->amount }}kg von {{ $score->competitor->name }}  ({{ $score->workout->name }})
                    </div>

                    <div class="text-center">
                        <div class="btn-group row" role="group" aria-label="Gültigkeit">
                            <button type="button" data-dismiss="modal" class="btn btn-danger" onclick="changeScoreValidity({{$score->id}}, 'invalid')">Ungültig</button>
                            <button type="button" data-dismiss="modal" class="btn" onclick="changeScoreValidity({{$score->id}}, 'undecided')">Noch nicht entschieden</button>
                            <button type="button" data-dismiss="modal" class="btn btn-success" onclick="changeScoreValidity({{$score->id}}, 'valid')">Gültig</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div data-toggle="modal" data-target="#createScoreForCompetitor{{$score->competitor_id}}Workout{{$score->workout_id}}Modal">
        {{ $score->amount }}
    </div>
    <div class="modal fade" id="createScoreForCompetitor{{$score->competitor_id}}Workout{{$score->workout_id}}Modal" tabindex="-1" role="dialog" aria-labelledby="createScoreForCompetitor{{$score->competitor_id}}Workout{{$score->workout_id}}ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="score{{$score->id}}ModalLabel">Score erstellen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="h2">
                        {{ $score->competitor->name }}  ({{ $score->workout->name }})
                    </div>
                    {{ Form::open(['action' => 'ScoreController@store'])}}
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
                    {{ Form::submit('Erstellen', ['class' => 'btn btn-success btn-big col']) }}
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endif
