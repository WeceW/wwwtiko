@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <ul class="nav nav-tabs">
            <li><a href="{{url('/tasks')}}">Tehtävät</a></li>
            <li class="active"><a href="{{url('/tasklists')}}">Tehtävälistat</a></li>
        </ul>

        <div class="panel panel-default">

            <!-- <div class="panel-heading">Tehtävät</div> -->

            <div class="panel-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="18">ID</th>
                            <th>Nimi</th>
                            <th>Kuvaus</th>
                            <th>Luoja</th>
                            <th width="20"></th>
                            <th width="20"></th>
                            <!-- <th>Luotu</th>
                            <th>Muokattu</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasklists as $tasklist)
                        <tr>
                            <td><small>{{$tasklist->id}}</small></td>
                            <td><strong>{{$tasklist->name}}</strong></td>
                            <td><small>{{$tasklist->description}}</small></td>
                            <td><small>{{\App\User::find($tasklist->creator)->name}}</small></td>

                            @if($tasklist->creator == auth()->user()->id )
                                <td>
                                    <form method="GET" action="{{ url('/tasklists/edit/') }}/{{$tasklist->id}}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ url('/tasklists/delete/') }}/{{$tasklist->id}}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-remove"></i></button>
                                    </form>
                                </td>
                            @else
                                <td></td>
                                <td></td>
                            @endif

                            <!-- <td>{{$tasklist->created_at}}</td>
                            <td>{{$tasklist->updated_at}}</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>

                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ url('/tasklists/create') }}" class="btn btn-primary">Luo uusi tehtävälista</a>
                    </div>
                </div>

            </div>  

        </div>
    </div>
</div>

@endsection
