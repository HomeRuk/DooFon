@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-10">
                        <span class="fa fa-mobile fa-5x"></span>
                        <span style="font-size:38px; margin-left: 2%">รายการอุปกรณ์ IoT</span>
                    </div>
                    <div class="col-md-2">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <br>
                            <a href="{{ url('/devices/create') }}" class="btn btn-blue">
                                <span class="fa fa-plus-circle"></span> Add Device
                            </a>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        {!! Form::open(['method' => 'GET','url'=>'/devices','class'=>'','role','search' ])!!}
                        <div class="input-group custom-search-form">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา SerialNumber">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default-sm">
                                <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-0">
                            @foreach ($devices as $device)
                                <div class="box">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-1">
                                                <img class="img-responsive img-thumbnail img-circle"
                                                     src="{{ asset('/images/device.png') }}"
                                                     style="border: 1px solid #4fc3f7;">
                                            </div>
                                            <div class="col-md-5">
                                                <h4>{{ $device->SerialNumber }}
                                                    <small> อัพเดทล่าสุด
                                                        : {{ $device->updated_at->diffForHumans(Carbon\Carbon::now()) }}</small>
                                                </h4>
                                                @if($device->weather()->count()>0)
                                                    <button class="btn btn-sm btn-success">
                                                        <span class="fa fa-cloud"></span>
                                                        {{ $device->weather->last()->PredictPercent }} %
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm disabled">
                                                        <span class="fa fa-cloud"></span>
                                                    </button>
                                                @endif
                                                ตำแหน่งล่าสุด : {{ $device->latitude }} ,{{ $device->threshold }}
                                            </div>
                                            <div class="col-md-3">
                                                <a class="btn btn-blue btn-block"
                                                   href="{{  url('/devices/'.$device->SerialNumber)}}">
                                                    <span class="fa fa-eye"></span> ดูรายละเอียด
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-blue btn-block">
                                                    <span class="fa fa-globe"></span> ตำแหน่งบนแผนที่
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="lineblue">
                            @endforeach
                        </div>
                        {!! $devices->render() !!}
                    </div>
                </div>
                {{--
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-custom-horrible-blue">
                            <div class="panel-heading">
                                <h4> Device จำนวน {{ $devices->total() }} เครื่อง</h4>
                            </div>
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
                                                    <a class="btn btn-sm btn-warning"
                                                       href="{{ url('/devices/'.$device->SerialNumber.'/edit') }}">
                                                        <span class="fa fa-pencil"></span>
                                                    </a>
                                                    {!! Form::open(array('url' => 'devices/'.$device->SerialNumber,'method' => 'delete','style'=>'display:inline')) !!}
                                                    <button class="btn btn-sm btn-danger"><span
                                                                class="fa fa-trash"></span>
                                                    </button>
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
                --}}
            </div>
        </div>
    </div>
@endsection

﻿<?php
/* header('Content-Type: application/json; charset=utf-8');
  $json = json_decode($devices);
  echo json_encode($json, JSON_PRETTY_PRINT); */
?>