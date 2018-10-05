@extends('layouts.master')

@section('content')
    <table data-toggle="table"
           data-mobile-responsive="true"
           data-check-on-init="true"
    >
        <thead class="table">
            <tr>
                <th rowspan="2" data-field="name"> <span class="not-in-card"> Name </span></th>
                <th rowspan="2" data-field="weight"> <span class="not-in-card"> Gewicht  </span></th>
                @foreach(App\Workout::all() as $workout)
                    <th scope="col" colspan="3"> {{ $workout->name }} </th>
                @endforeach
                <th rowspan="2" data-field="total" data-sortable="true">Total</th>
                <th rowspan="2" data-field="wilks" data-sortable="true">Wilks</th>
            </tr>
            <tr>
                @foreach(App\Workout::all() as $workout)
                    <th> 1. Versuch </th>
                    <th> 2. Versuch </th>
                    <th> 3. Versuch </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($orderedCompetitors as $competitor)
                <tr class="{{$competitor->is($currentCompetitor) ? "current-lifter" : "" }}">
                    <td>
                        <a href="/competitor/{{$competitor->id}}" class="name-fat">
                            {{ $competitor->name }}
                        </a>
                    </td>
                    <td>
                        {{ number_format($competitor->weight, 1)}} 
                    </td>
                    @foreach(App\Workout::all() as $workout)
                        @foreach($competitor->powerliftingScores($workout) as $score)
                            <td class="{{ $score->tableClassAttribute()}}"> {{ number_format($score->amount, 2) }} </td>
                        @endforeach
                    @endforeach
                    <td>{{ number_format($competitor->powerliftingTotal(), 2) }}</td>
                    <td>{{ number_format(App\Scoring::wilksPoints($competitor), 2)}}</td>
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
