@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <ul class="nav nav-tabs">
            <li><a href="{{url('/tasks')}}">Tehtävät</a></li>
            <li class="active"><a href="{{url('/tasklists')}}">Tehtävälistat</a></li>
        </ul>
        
        <div class="panel panel-default">

            <div class="panel-heading">Muokkaa tehtävälistaa</div>

            <div class="panel-body">
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/tasklists/edit') }}/{{$tasklist->id}}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Nimi</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $tasklist->name }}">

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
                            <textarea id="description" class="form-control" name="description">{{ $tasklist->description }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tasks') ? ' has-error' : '' }}">
                        <label for="tasks" class="col-md-4 control-label">Tehtävät</label>

                        <div class="col-md-6">
                            @if ($errors->has('tasks'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tasks') }}</strong>
                                </span>
                            @endif
                            
                            @foreach ($tasks as $task)
                            <div class="checkbox">
                                <label><input type="checkbox" name="tasks[]" value="{{$task->id}}" 
                                    {{ $task->tasklists->pluck('id')->contains($tasklist->id) ? " checked" : "" }} 
                                />
                                    <strong>{{ $task->name }}</strong>
                                </label>
                                <br><span style="color: #ccc;">{{'   (' . $task->description . ') ' }}</span>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Päivitä tehtävälista
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
