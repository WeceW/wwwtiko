@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="panel panel-default">

            <div class="panel-heading"><strong>YHTEENVETO</strong>
                <small></small>
                <small class="pull-right"></small>
            </div>

            <div class="panel-body">
                
                <div class="row">

                    <div class="col-md-12">
                        <h3 class="text-success">Valmis!</h3>
                        <p>Kokonaisaika: {{$session_time}}</p>
                       
                        Tehtävät:
                        <table style="font-size: 80%;" class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <td><strong>Tehtävä</strong></td>
                                    <td><strong>Yritys</strong></td>
                                    <td><strong>Aika</strong></td>
                                    <td><strong>Tulos</strong></td>
                                    <td><strong>Vastaus</strong></td>
                                    <td><strong>Oikea ratkaisu</strong></td>
                                </tr>
                            </thead>
                            @foreach ($summary as $row)
                                <tr style="font-size: 90%;">
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
                <small>Sessio suoritettu</small>
                <small class="pull-right">Käyttäjä: {{auth()->user()->name}}</small>
            </div>

        </div>
    </div>
</div>



@endsection
