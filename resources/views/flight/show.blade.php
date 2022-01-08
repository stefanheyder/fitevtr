@extends('layouts.master')

@section('content')
    <table data-toggle="table"
           data-mobile-responsive="true"
           data-check-on-init="true"
           data-sort-name="wilks"
           data-sort-order="desc"
           data-show-columns="true"
    >
        <thead class="table">
            <tr>
                <th rowspan="2" data-field="name"> <span class="not-in-card"> Name </span></th>
                @foreach($flight->workouts as $workout)
                    <th colspan="4"> {{ $workout->name }} </th>
                @endforeach
                @if($flight->workouts->count() > 1)
                    <th colspan="2">
                        Gesamt
                    </th>
                @endif
            </tr>
            <tr>
                @foreach($flight->workouts as $workout)
                    <th> 1. </th>
                    <th> 2. </th>
                    <th> 3. </th>
                    <th> Punkte </th>
                @endforeach
                @if(count($flight->workouts) > 1 )
                    <th>
                        Gewicht
                    </th>
                    <th>
                        Punkte
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($orderedCompetitors as $competitor)
                <tr class="{{$competitor->is($currentCompetitor) ? "" : "" }}">
                    <td>
                        <a href="/competitor/{{$competitor->id}}" class="name-fat">
                            {{ $competitor->name }} ({{ $competitor->team->shorthand }})
                        </a>
                    </td>
                    @foreach($flight->workouts as $workout)
                        @foreach($competitor->powerliftingScores($workout) as $score)
                            <td class="{{ $score->tableClassAttribute()}}">
                                @include('lift.editmodal', ['lift' => $score])
                            </td>
                        @endforeach
                        <td >
                            {{number_format($flight->competition->singlePoints($competitor, $workout), 2)}}
                        </td>
                    @endforeach
                    @if($flight->workouts->count() > 1)
                        <td>
                            {{number_format($flight->competition->singleTotalWeight($competitor, $flight->workouts), 0)}}
                        </td>
                        <td>
                            {{number_format($flight->competition->singleTotalPoints($competitor, $flight->workouts), 2)}}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

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
