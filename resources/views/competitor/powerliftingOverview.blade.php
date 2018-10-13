@extends('layouts.master')

@section('content')
    <table data-toggle="table"
           data-sort-name="wilks"
           data-sort-order="desc"
           data-search="true"
    >
        <thead class="table">
            <tr>
                <th data-field="name"> Name </th>
                <th data-field="weight"> Gewicht </th>
                @foreach(App\Workout::all() as $workout)
                    <th scope="col" colspan="3"> {{ $workout->name }} </th>
                @endforeach
                <th data-field="total" data-sortable="true">
                    Total
                </th>
                <th data-field="wilks" data-sortable="true">
                    Wilks Punkte
                </th>
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
                    <td>
                        {{ number_format($competitor->weight, 1)}} 
                    </td>
                    @foreach(App\Workout::all() as $workout)
                        <td> {{ $workout->formatScore($competitor->bestScore($workout)) }} </td>
                        <td> 
                            <a class="fas fa-plus-circle text-success" href={{route('judge.workout', ["w" => $workout, "c" => $competitor])}}> 

                            </a>
                        </td>
                        <td>
                            @php
                                $bestScore = $competitor->scoresInWorkout($workout)->orderBy('amount', 'desc')->first()
                            @endphp
                            <a class="fas fa-pencil-alt  {{$bestScore ? "text-warning" : "text-muted"}}" href={{route('score.edit', ["score" => $bestScore])}}> 

                            </a>
                        </td>
                    @endforeach
                    <td>
                        {{ number_format($competitor->powerliftingTotal($competitor->flight()))}}
                    </td>
                    <td>
                        {{ number_format(App\Scoring::wilksPoints($competitor, $competitor->flight()), 2)}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
