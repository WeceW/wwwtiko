@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">Raportit</div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <a href="{{url('/reports/1')}}" class="col-md-10">R1: <small>Onnistuneiden tehtävien lukumäärä sessioittain</small></a><br>
                        <a href="{{url('/reports/2')}}" class="col-md-10">R2: <small>Session nopein, hitain ja keskimääräinen suoritusaika tehtävälistakohtaisesti</small></a><br>
                        <a href="{{url('/reports/3')}}" class="col-md-10">R3: <small>Tehtävälistan yhteenvetotiedot tehtäväkohtaisesti (tehtäväkuvaukset, onnistumisprosentit, keskimääräinen aika)</small></a><br>
                        <a href="{{url('/reports/4')}}" class="col-md-10">R4: <small>Kaikki tehtävät vaikeusjärjestyksessä. Keskimääräisten yritysten määrä (onnistuneet), sekä epäonnistuneiden prosenttiosuus</small></a><br>
                        <a href="{{url('/reports/5')}}" class="col-md-10">R5: <small>Kyselyt tyypeittäin (Select, Insert jne.), yritysten keskimääräinen lukumäärä sekä keskimäärin käytetty aika.</small></a><br>
                        <!-- <a href="/reports/4" class="col-md-10">Raportti 4</a><br>
                        <a href="/reports/5" class="col-md-10">Raportti 5</a><br> -->
                    </div>
                </div>


                </div>

            </div>
        </div>
    </div>
</div>

@endsection
