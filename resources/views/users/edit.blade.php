@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
                
            <div class="panel-heading">Käyttäjätiedot</div>

            <div class="panel-body">
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/users/edit') }}/{{$user->id}}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Nimi</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('student_nro') ? ' has-error' : '' }}">
                        <label for="student_nro" class="col-md-4 control-label">Opiskelijanumero</label>

                        <div class="col-md-6">
                            <input id="student_nro" type="text" class="form-control" name="student_nro" value="{{$user->student_nro}}">

                            @if ($errors->has('student_nro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student_nro') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('major') ? ' has-error' : '' }}">
                        <label for="major" class="col-md-4 control-label">Pääaine</label>

                        <div class="col-md-6">
                            <input id="major" type="text" class="form-control" name="major" value="{{$user->major}}">

                            @if ($errors->has('major'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('major') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                        <label for="major" class="col-md-4 control-label">Roolit</label>

                        <div class="col-md-6">
                            @foreach ($allRoles as $role)
                                <label><input type="checkbox" name="roles[]" value="{{$role->id}}" {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}> {{ $role->name }} </input></label> <br>
                            @endforeach
                        </div>
                    </div>  


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Päivitä tiedot
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
