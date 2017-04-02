@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="panel panel-default">

            <div class="panel-heading"><strong>Raportti {{$id}}</strong>
                <small></small>
                <small class="pull-right"></small>
            </div>

            <div class="panel-body">
                
                <div class="row">

                    <div class="col-md-12">
                        <p>{{$description}}</p>
                       
                        <table style="font-size: 80%;" class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    @foreach ($columns as $column)
                                        <td><strong>{{$column}}</strong></td>
                                    @endforeach
                                </tr>
                            </thead>
                            @foreach ($report as $row)
                                <tr style="font-size: 90%;">
                                    @foreach ($row as $column)
                                        <td>{{$column}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                        <p></p>
                    </div>

                </div>

            </div>

            <div class="panel-footer">
                <a href="{{url('/reports')}}" class="col-md-10">Takaisin</a><br>
                <small class="pull-right">...</small>
            </div>

        </div>
    </div>
</div>



@endsection
