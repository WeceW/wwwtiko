@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <ul class="nav nav-tabs">
            <li class="active"><a href="{{url('/users')}}">Käyttäjät</a></li>
            <!-- <li><a href="{{url('/users/roles')}}">Oikeudet</a></li> -->
        </ul>

        <div class="panel panel-default">
            <!-- <div class="panel-heading">Tehtävät</div> -->

            <div class="panel-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="18">ID</th>
                            <th>Nimi</th>
                            <th>Opiskelijanumero</th>
                            <th>Pääaine</th>
                            <th>Rekisteröitynyt</th>
                            <th>Roolit</th>
                            <th width="20"></th>
                            <th width="20"></th>
                            <!-- <th>Luotu</th>
                            <th>Muokattu</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td><small>{{$user->id}}</small></td>
                            <td><strong>{{$user->name}}</strong></td>
                            <td><small>{{$user->student_nro}}</small></td>
                            <td><small>{{$user->major}}</small></td>
                            <td><small>{{$user->created_at}}</small></td>
                            <td><small>{{$user->roles->implode('name', ', ')}}</small></td>

                            @can('manage-users')
                            <td>
                                <form method="GET" action="{{ url('/users/edit') }}/{{$user->id}}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-pencil"></i></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ url('/users/delete/') }}/{{$user->id}}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-remove"></i></button>
                                </form>
                            </td>
                            @endcan

                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>  

        </div>
    </div>
</div>

@endsection
