@extends('layouts.master')

@section('content')
    <table data-toggle="table"
           data-mobile-responsive="true"
           data-check-on-init="true"
           data-sort-name="id"
           data-sort-order="desc"
    >
        <thead class="table">
            <tr>
                <th data-field="id"> # </th>
                <th data-field="title"> Titel </th>
                <th> Heber </th>
            </tr>
        </thead>
        <tbody>
            @foreach($flights as $flight)
                <tr>
                    <td>
                        {{ $flight->id }}
                    </td>
                    <td>
                        <a href="/flight/{{$flight->id}}" >
                            {{ $flight->title }}
                        </a>
                    </td>
                    <td>
                        {{ $flight->competitors->implode('name', '<br>') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
