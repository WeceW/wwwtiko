@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">Aloita tehtävälistan suoritus</div>

            <div class="panel-body">

                <ul>
                    @foreach ($tasklists as $tasklist)
                    <li>
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
                    <hr>
                    @endforeach
                </ul>

            </div>

        </div>
    </div>
</div>

@endsection
