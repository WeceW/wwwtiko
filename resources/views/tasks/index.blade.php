@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <ul class="nav nav-tabs">
            <li class="active"><a href="{{url('/tasks')}}">Tehtävät</a></li>
            <li><a href="{{url('/tasklists')}}">Tehtävälistat</a></li>
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
                            <!-- <th>Ratkaisu</th> -->
                            <!-- <th>Tyyppi</th> -->
                            <!-- <th>Rakennekaavio</th> -->
                            <th>Luoja</th>
                            <th width="20"></th>
                            <th width="20"></th>
                            <!-- <th>Luotu</th>
                            <th>Muokattu</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td><small>{{$task->id}}</small></td>
                            <td><strong>{{$task->name}}</strong></td>
                            <td><small>{{$task->description}}</small></td>
                            <!-- <td><small>{{$task->solution}}</small></td> -->
                            <!-- <td><small>{{$task->type}}</small></td> -->
                            <!-- <td><small>{{$task->diagram}}</small></td> -->
                            <td><small>{{\App\User::find($task->creator)->name}}</small></td>

                            @if($task->creator == auth()->user()->id )
                            <td>
                                    <form method="GET" action="{{ url('/tasks/edit/') }}/{{$task->id}}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ url('/tasks/delete/') }}/{{$task->id}}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-remove"></i></button>
                                </form>
                            </td>
                            @else
                            <td></td><td></td>
                            @endif

                            <!-- <td>{{$task->created_at}}</td>
                            <td>{{$task->updated_at}}</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>

                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ url('/tasks/create') }}" class="btn btn-primary">Lisää uusi tehtävä</a>
                    </div>
                </div>

            </div>  

        </div>
    </div>
</div>

@endsection
