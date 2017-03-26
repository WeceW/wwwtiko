@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">Aloita tehtävälistan suoritus</div>

            <div class="panel-body">

                <ul>
                    @foreach ($tasklists as $tasklist)
                    <div class="row col-md-12">
                        <li>
                            <hr>
                            <p><strong>{{$tasklist->name}}</strong> 
                                <span class="pull-right" style="color: #999; font-size: 90%;">{{$tasklist->tasks()->count()}} tehtävää</span><br>
                                {{$tasklist->description}}
                                <span class="pull-right" style="color: #999; font-size: 90%;">Tekijä: {{ App\User::find($tasklist->creator)->name}}</span><br>
                                <span class="pull-right" style="color: #999; font-size: 90%;">Julkaistu: {{ $tasklist->created_at->toDateString()}}</span><br>
                            </p>
                            <form class="form-horizontal" role="form" method="POST" action="{{url('/session/start')}}/{{$tasklist->id}}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-primary">Aloita</button>
                            </form>
                        </li> 

                    </div>

                    <div class="row col-md-12">
                        <div class="panel panel-default" style="background-color: #f2f2f2; margin-top: 20px;">

                            <div class="panel-heading">Kommentit</div>

                            <div class="panel panel-body" style="background-color: #f2f2f2; padding: 20px;">
                                <comment-form tasklistid="{{$tasklist->id}}"></comment-form>
                                <br>
                                <comment-list
                                        tasklistid="{{(int)$tasklist->id}}"
                                        candelete="{{var_export(Gate::allows('remove-comment'), true)}}">
                                </comment-list>
                            </div>
                        </div>
                    </div>

                    <br>
                    @endforeach
                </ul>

            </div>

        </div>
    </div>
</div>

@endsection
