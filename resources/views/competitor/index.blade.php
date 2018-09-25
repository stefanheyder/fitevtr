@extends('layouts.master')

@section('content')
    <table data-toggle="table"
           data-mobile-responsive="true"
           data-check-on-init="true"
           data-sort-name="total"
           data-sort-order="desc"
    >
        <thead class="table">
            <tr>
                <th rowspan="2" data-field="name"> <span class="not-in-card"> Name </span></th>
                @foreach(App\Workout::all() as $workout)
                    <th scope="col" colspan="2"> {{ $workout->name }} </th>
                @endforeach
                <th rowspan="2" data-sortable="true" data-field="total"> Gesamtpunkte</th>
            </tr>
            <tr>
                @foreach(App\Workout::all() as $workout)
                    <th data-sortable="true" data-field="{{$workout->id}}.score"> <span class="only-in-card">{{$workout->name}} </span> <span class="not-in-card">Ergebnis</span> </th>
                    <th data-sortable="true" data-field="{{$workout->id}}.points"> <span class="not-in-card"> Punkte </span></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach(App\Competitor::all() as $competitor)
                <tr>
                    <td>
                        <a href="/competitor/{{$competitor->id}}" class="name-fat">
                            {{ $competitor->name }}
                        </a>
                    </td>
                    @foreach(App\Workout::all() as $workout)
                        <td> {{ $workout->formatScore($competitor->bestScore($workout)) }} </td>
                        <td> {{ App\Scoring::pointsFromWorkout($competitor, $workout) }} </td>
                    @endforeach
                    <td>
                        {{ App\Scoring::totalPoints($competitor) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
