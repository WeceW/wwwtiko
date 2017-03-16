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
                        <p><a href="{{url('/session')}}/{{$tasklist->id}}" id="{{$tasklist->id}}" class="btn-sm btn-primary">Aloita</a></p>
                    </li> 
                    <hr>
                    @endforeach
                </ul>

            </div>

        </div>
    </div>
</div>

@endsection
