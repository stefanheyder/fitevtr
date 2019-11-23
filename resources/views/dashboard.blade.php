@extends('layouts.master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Flights
                <a href="{{route('flight.create')}}" class="fas fa-plus-circle"></a>
            </h3>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach(App\Flight::all() as $flight)
                    <li class="list-group-item">
                        <a href={{route('flight.show', $flight)}}>
                            {{$flight->title}}  (Beendet: {{ $flight->finished() ? 'Ja' : 'Nein' }})
                        </a>
                        <a href={{route('flight.edit', $flight)}} class="fas fa-pencil-alt pull-right">

                        </a>
                        <form action="{{ route('flight.destroy', $flight) }}" method="POST" style="display: inline;" class="pull-right">
                            @method('DELETE')
                            @csrf
                            <button class="fas fa-trash btn btn-link"></button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Competitors
                <a href="{{route('competitor.create')}}" class="fas fa-plus-circle"></a>
            </h3>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach(App\Competitor::orderBy('name')->get() as $competitor)
                    <li class="list-group-item">
                        <a href={{route('competitor.show', $competitor)}}>
                            {{$competitor->name}}
                        </a>
                        <a href={{route('competitor.edit', $competitor)}} class="fas fa-pencil-alt">

                        </a>
                        <form action="{{ route('competitor.destroy', $competitor) }}" method="POST" style="display: inline;">
                            @method('DELETE')
                            @csrf
                            <button class="fas fa-trash btn btn-link"></button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div>

    <modal></modal>
    </div>
@stop
