@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Lists Weather {{ $count }} list</div>      
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"> 
                            <thead>
                                <tr class="active">
                                    <th>id</th>
                                    <th>temp</th>
                                    <th>humidity</th>
                                    <th>dewpoint</th>
                                    <th>pressure</th>
                                    <th>light</th>
                                    <th>rain</th>
                                    <th>PredictPercent</th>
                                    <th>PredictStatus</th>
                                    <th>SerialNumber</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Weathers as $Weather)
                                <tr>
                                    <td>{{ $Weather->id }}</td>
                                    <td>{{ $Weather->temp }}</td>
                                    <td>{{ $Weather->humidity }}</td>
                                    <td>{{ $Weather->dewpoint }}</td>
                                    <td>{{ $Weather->pressure }}</td>
                                    <td>{{ $Weather->light }} </td>
                                    <td>{{ $Weather->rain }} </td>
                                    <td>{{ $Weather->PredictPercent }}</td>
                                    <td>{{ $Weather->PredictStatus }}</td>
                                    <td>{{ $Weather->SerialNumber }}</td>
                                    <td>{{ $Weather->created_at }}</td>
                                    <td>{{ $Weather->updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $Weathers->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
﻿<?php
/* header('Content-Type: application/json; charset=utf-8');
  $json = json_decode(Weathers);
  echo json_encode($json, JSON_PRETTY_PRINT); */
?>

