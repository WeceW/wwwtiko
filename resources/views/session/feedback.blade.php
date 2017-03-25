@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="panel panel-default">

            <div class="panel-heading"><strong>PALAUTE:</strong>  {{$task->name}} 
                <small>(yritys {{ $taskAttempt->count}}/3)</small>
                <small class="pull-right">Tehtävä {{$currentTaskNo}}/{{$taskCount}}</small>
            </div>

            <div class="panel-body">

                <div class="row">
                    <span class="col-md-4"></span>

                    <div class="col-md-6">
                        @if ($taskAttempt->result)
                            <h3 class="text-success">{{'Oikea vastaus!'}}</h3>
                        @else
                            <h3 class="text-danger">{{'Virheellinen vastaus!'}}</h3><br>
                            @if ($queryExc != '')
                                <p class="text-danger">{{$queryExc}}<p>
                            @endif
                        @endif
                        <br>

                        @if ($nextTaskId == $task->id)
                        <a href="{{url('/session')}}/{{$session->id}}/{{$nextTaskId}}" class="btn btn-primary">Yritä uudestaan</a>
                        @elseif ($nextTaskId > $task->id)
                        <a href="{{url('/session')}}/{{$session->id}}/{{$nextTaskId}}" class="btn btn-primary">Seuraava tehtävä</a>
                        @elseif ($nextTaskId == 0)
                        <a href="{{url('/session')}}/{{$session->id}}/summary" class="btn btn-primary">Valmis!</a>
                        @endif

                        <hr>

                        <p><strong>{{$task->description}}</strong></p>

                        Vastauksesi tulos:
                        <table class="table table-condensed table-striped">
                            @foreach ($result as $row)
                                <tr>
                                    @foreach ($row as $column)
                                        <td>{{$column}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>

            </div>

            <div class="panel-heading">Oikea ratkaisu</div>
            <div class="panel-body">
                
                <div class="row">
                    <span class="col-md-4"></span>

                    <div class="col-md-6">
                        @if ($taskAttempt->count == 3)
                            <p><span class="text-success"> Oikea vastaus: </span><br>
                            {{$task->solution}}</p>
                        @endif
                        
                        Oikea tulos:
                        <table class="table table-condensed table-striped">
                            @foreach ($exampleResult as $row)
                                <tr>
                                    @foreach ($row as $column)
                                        <td>{{$column}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>

            </div>

            <div class="panel-footer">
                <small>Sessio aloitettu: {{$session->start_time}}</small>
                <small class="pull-right">Käyttäjä: {{auth()->user()->name}}</small>
            </div>

        </div>
    </div>
</div>



@endsection
