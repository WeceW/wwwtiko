@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="panel panel-default">

            <div class="panel-heading">{{$task->name}} 
                <small>(yritys {{ $taskAttempt->count}}/3)</small>
                <small class="pull-right">Tehtävä {{$currentTaskNo}}/{{$taskCount}}</small>
            </div>

            <div class="panel-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/session')}}/{{$session->id}}/{{$task->id}}/save">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <span class="col-md-4"></span>

                        <div class="col-md-6">
                            <small>Tee seuraava SQL-kysely: </small><br>
                            <strong>{{$task->description}}</strong>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('userQuery') ? ' has-error' : '' }}">
                        <label for="userQuery" class="col-md-4 control-label">Kysely</label>

                        <div class="col-md-6">
                            <textarea id="userQuery" class="form-control" name="userQuery">{{ old('userQuery') }}</textarea>

                            @if ($errors->has('userQuery'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('userQuery') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-send"></i> Lähetä vastaus
                            </button>
                        </div>
                    </div>

                </form>

            </div>

            <div class="panel-heading">Tietokannan rakenne</div>
            <div class="panel-body">
                
                <div class="row">
                    <span class="col-md-3"></span>
                    <div class="col-md-6">
                        <img src="{{ url('images/esimerkkikanta/SQL-kaavio.jpg') }}">
                        <!-- <img src=" url(task->diagram) " width="100%">   LISÄÄ TÄNNE AALTOSULUT JOS TULEE KÄYTTÖÖN--> 
                    </div>
                    <span class="col-md-3"></span>
                </div>

                <hr>
                
                <div class="row">
                    <span class="col-md-1"></span>
                    <div class="col-md-3">
                        Opiskelijat:
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <td><strong>nro</strong></td>
                                    <td><strong>nimi</strong></td>
                                    <td><strong>p_aine</strong></td>
                                </tr>
                            </thead>
                        @foreach ($opiskelijat as $opiskelija)
                            <tr>
                                <td>{{$opiskelija->nro}}</td>
                                <td>{{$opiskelija->nimi}}</td>
                                <td>{{$opiskelija->p_aine}}</td>
                            </tr>
                        @endforeach
                        </table>
                    </div>

                    <div class="col-md-3">
                        Kurssit:
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <td><strong>id</strong></td>
                                    <td><strong>nimi</strong></td>
                                    <td><strong>opettaja</strong></td>
                                </tr>
                            </thead>
                        @foreach ($kurssit as $kurssi)
                            <tr>
                                <td>{{$kurssi->id}}</td>
                                <td>{{$kurssi->nimi}}</td>
                                <td>{{$kurssi->opettaja}}</td>
                            </tr>
                        @endforeach
                        </table>
                    </div>

                    <div class="col-md-3">
                        Suoritukset:
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <td><strong>k_id</strong></td>
                                    <td><strong>op_nro</strong></td>
                                    <td><strong>arvosana</strong></td>
                                </tr>
                            </thead>
                        @foreach ($suoritukset as $suoritus)
                            <tr>
                                <td>{{$suoritus->k_id}}</td>
                                <td>{{$suoritus->op_nro}}</td>
                                <td>{{$suoritus->arvosana}}</td>
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
