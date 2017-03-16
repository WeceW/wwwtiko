@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">Omat tiedot</div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-2">ID:</div>
                    <div class="col-md-6">{{auth()->user()->id}}</div>
                </div>

                <div class="row">
                    <div class="col-md-2">Nimi:</div>
                    <div class="col-md-6">{{auth()->user()->name}}</div>
                </div>

                <div class="row">
                    <div class="col-md-2">Opiskelijanumero:</div>
                    <div class="col-md-6">{{auth()->user()->student_nro}}</div>
                </div>

                <div class="row">
                    <div class="col-md-2">Pääaine:</div>
                    <div class="col-md-6">{{auth()->user()->major}}</div>
                </div>

                <div class="row">
                    <div class="col-md-2">Käyttäjäryhmä(t):</div>
                    <div class="col-md-6">
                        @foreach (auth()->user()->roles as $role)
                            {{$role->label}}<br>
                        @endforeach
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-2">Rekisteröitynyt:</div>
                    <div class="col-md-6">{{auth()->user()->created_at->toFormattedDateString()}}</div>
                </div>

                <div class="row">
                    <div class="col-md-2">Viimeksi muokattu:</div>
                    <div class="col-md-6">{{auth()->user()->updated_at->toDayDateTimeString()}}</div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ url('/my-account/edit') }}/{{ auth()->user()->id}}" class="btn btn-primary">Muokkaa tietoja</a>
                    </div>
                    <div class="col-md-2">
                        <form class="form" role="form" method="POST" action="{{ url('/my-account/delete') }}/{{ auth()->user()->id}}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default">Poista käyttäjätili</button>
                        </form>
                    </div>
                    <!-- <div class="col-md-2">
                    <a href="{{ url('/my-account/update/')}}" class="btn btn-primary">Vaihda salasana</a>
                    </div> -->
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
