@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-10">
                        <span class="fa fa-mobile fa-5x"></span>
                        <span style="font-size:38px; margin-left: 2%">รายละเอียด</span>
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
                    <div class="box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <img class="img-responsive img-thumbnail img-circle"
                                         src="{{ asset('/images/device.png') }}" style="border: 1px solid #4fc3f7;">
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ $device->SerialNumber }}
                                        <small> อัพเดทล่าสุด
                                            : {{ $device->updated_at->diffForHumans(Carbon\Carbon::now()) }}</small>
                                    </h4>
                                    <button class="btn btn-sm btn-success">
                                        <span class="fa fa-cloud"></span> {{ $device->threshold }}%
                                    </button>
{{--                                 @if (isset($lastWeather->temp))
                                         <button class="btn btn-sm">{{ $lastWeather->temp }}</button>
                                     @endif
                                     @if (isset($lastWeather->humidity))
                                         <button class="btn btn-sm">{{ $lastWeather->humidity }}</button>
                                     @endif
                                     @if (isset($lastWeather->dewpoint))
                                         <button class="btn btn-sm">{{ $lastWeather->dewpoint }}</button>
                                     @endif
                                     @if (isset($lastWeather->pressure))
                                         <button class="btn btn-sm">{{ $lastWeather->pressure }}</button>
                                     @endif
                                     @if (isset($lastWeather->light))
                                         <button class="btn btn-sm">{{ $lastWeather->light }}</button>
                                     @endif
                                     @if (isset($lastWeather->rain))
                                         <button class="btn btn-sm">{{ $lastWeather->rain }}</button>
                                     @endif
 --}}
                                    @if($device->weather()->count()>0)
                                        <button class="btn btn-sm">{{ $device->weather->last()->temp }}</button>
                                        <button class="btn btn-sm">{{ $device->weather->last()->humidity }}</button>
                                        <button class="btn btn-sm">{{ $device->weather->last()->dewpoint }}</button>
                                        <button class="btn btn-sm">{{ $device->weather->last()->pressure }}</button>
                                        <button class="btn btn-sm">{{ $device->weather->last()->light }}</button>
                                        <button class="btn btn-sm">{{ $device->weather->last()->rain }}</button>
                                    @endif
                                    ตำแหน่งล่าสุด : {{ $device->latitude }},{{ $device->threshold }}
                                </div>
                                <div class="col-md-5">
                                    <div class="col-md-12">
                                        <button class="btn btn-blue btn-sm btn-block">
                                            <span class="fa fa-globe"></span> ตำแหน่งบนแผนที่
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="col-md-6">
                                        <a class="btn btn-sm btn-warning btn-block"
                                           href="{{ url('/devices/'.$device->SerialNumber.'/edit') }}">
                                            <span class="fa fa-pencil"></span> แก้ไข
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::open(array('url' => 'devices/'.$device->SerialNumber,'method' => 'delete','style'=>'display:inline')) !!}
                                        <button class="btn btn-sm btn-danger btn-block">
                                            <span class="fa fa-trash"></span> ลบ
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="active">
                                    <th>ลำดับ</th>
                                    <th>อุณหภูมิ</th>
                                    <th>ความชื้น</th>
                                    <th>อุณหภูมจุดน้ำค้าง</th>
                                    <th>ความกดอากาศ</th>
                                    <th>ความสว่าง</th>
                                    <th>ค่าฝน</th>
                                    <th>ค่าพยากรณ์ฝน%</th>
                                    <th>ชื่อโมเดลในการพยากรณ์</th>
                                    <th>อัพเดทล่าสุด</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dWeathers as $dWeather)
                                    <tr>
                                        <td>{{ $dWeather->id }}</td>
                                        <td>{{ $dWeather->temp }}</td>
                                        <td>{{ $dWeather->humidity }}</td>
                                        <td>{{ $dWeather->dewpoint }}</td>
                                        <td>{{ $dWeather->pressure }}</td>
                                        <td>{{ $dWeather->light }} </td>
                                        <td>{{ $dWeather->rain }} </td>
                                        <td>
                                            @if(!empty($dWeather->PredictPercent))
                                                {{ $dWeather->PredictPercent }}
                                            @else
                                                <div style="text-align: center;">-</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($dWeather->model_id))
                                                <a href="{{ url('model_predict/'.$dWeather->modelpredict->id) }}">{{ $dWeather->modelpredict->modelname}}</a>
                                            @else
                                                <div style="text-align: center;">-</div>
                                            @endif
                                        </td>
                                        <td>{{ $dWeather->updated_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $dWeathers->render() !!}
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