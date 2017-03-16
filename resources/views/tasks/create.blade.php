@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
            
        <ul class="nav nav-tabs">
            <li><a href="{{url('/tasks')}}">Tehtävät</a></li>
            <li><a href="{{url('/tasklists')}}">Tehtävälistat</a></li>
        </ul>

        <div class="panel panel-default">

            <div class="panel-heading">Lisää uusi tehtävä</div>

            <div class="panel-body">
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/tasks/create') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Nimi</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-4 control-label">Kuvaus</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('solution') ? ' has-error' : '' }}">
                        <label for="solution" class="col-md-4 control-label">Ratkaisu</label>

                        <div class="col-md-6">
                            <textarea id="solution" class="form-control" name="solution">{{ old('solution') }}</textarea>

                            @if ($errors->has('solution'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('solution') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label for="type" class="col-md-4 control-label">Tyyppi</label>

                        <div class="col-md-6">
                            <select id="type" class="form-control" name="type">
                                <option value="select" {{old('type') == 'select' ? ' selected' : ''}}>Select</option>
                                <option value="insert" {{old('type') == 'insert' ? ' selected' : ''}}>Insert</option>
                                <option value="update" {{old('type') == 'update' ? ' selected' : ''}}>Update</option>
                                <option value="delete" {{old('type') == 'delete' ? ' selected' : ''}}>Delete</option>
                            </select>
                            <!-- <input id="type" type="text" class="form-control" name="type" value="{{ old('type') }}"> -->

                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('diagram') ? ' has-error' : '' }}">
                        <label for="diagram" class="col-md-4 control-label">Rakennekaavio (linkki)</label>

                        <div class="col-md-6">
                            <input id="diagram" type="text" class="form-control" name="diagram" value="{{ old('diagram') }}">

                            @if ($errors->has('diagram'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('diagram') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Luo tehtävä
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



@endsection
