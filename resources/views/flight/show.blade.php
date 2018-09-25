@extends('layouts.master')

@section('content')
    <table data-toggle="table"
           data-mobile-responsive="true"
           data-check-on-init="true"
           data-sort-name="wilks"
           data-sort-order="desc"
    >
        <thead class="table">
            <tr>
                <th rowspan="2" data-field="name"> <span class="not-in-card"> Name (Gewicht) </span></th>
                @foreach(App\Workout::all() as $workout)
                    <th scope="col" colspan="3"> {{ $workout->name }} </th>
                @endforeach
                <th rowspan="2" data-sortable="true" data-field="total">Total</th>
                <th rowspan="2" data-sortable="true" data-field="wilks">Wilks</th>
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
            @foreach(App\Competitor::all() as $competitor)
                <tr>
                    <td>
                        <a href="/competitor/{{$competitor->id}}" class="name-fat">
                            {{ $competitor->name }} ({{ number_format($competitor->weight, 1)}} )
                        </a>
                    </td>
                    @foreach(App\Workout::all() as $workout)
                        @foreach($competitor->powerlifitingScores($workout) as $score)
                            <td class="{{ $score->tableClassAttribute()}}"> {{ $score->amount }} </td>
                        @endforeach
                    @endforeach
                    <td>{{ number_format($competitor->powerliftingTotal(), 2) }}</td>
                    <td>{{ number_format(App\Scoring::wilksPoints($competitor), 2)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
