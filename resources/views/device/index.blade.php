@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <a href="{{ url('/devices/create') }}" class="btn btn-lg btn-primary btn-block">Create Device</a>
                <hr/>
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h4> Device จำนวน {{ $devices->total() }} เครื่อง</h4></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="active">
                                    <th>SerialNumber</th>
                                    <th>latitude</th>
                                    <th>longitude</th>
                                    <th>Threshold</th>
                                    <th>Mode</th>
                                    <th>Updated_at</th>
                                    <th>Tools</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($devices as $device)
                                    <tr>
                                        <td>{{ $device->SerialNumber }}</td>
                                        <td>{{ $device->latitude }}</td>
                                        <td>{{ $device->longitude }}</td>
                                        <td>{{ $device->threshold }}</td>
                                        <td>
                                            @if(!empty($device->mode))
                                                {{ $device->mode }} hr
                                            @else
                                                <div style="text-align: center;">-</div>
                                            @endif
                                        </td>
                                        <td>{{ $device->updated_at }} </td>
                                        <td>
                                            <a class="btn btn-sm btn-warning" href="{{ url('/devices/'.$device->SerialNumber.'/edit') }}">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            {!! Form::open(array('url' => 'devices/'.$device->SerialNumber,'method' => 'delete','style'=>'display:inline')) !!}
                                            <button class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $devices->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

﻿<?php
/* header('Content-Type: application/json; charset=utf-8');
  $json = json_decode($devices);
  echo json_encode($json, JSON_PRETTY_PRINT); */
?>