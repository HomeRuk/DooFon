@extends('layouts.user.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-10">
                        <span class="fa fa-mobile fa-5x"></span>
                        <span style="font-size:38px; margin-left: 2%">รายการอุปกรณ์IoT</span>
                    </div>
                    <div class="col-md-2">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <br>
                            <div class="form-group">
                                <a href="{{ url('/user/devices/create') }}" class="btn btn-blue">
                                    <span class="fa fa-plus-circle"></span> เพิ่มอุปกรณ์IoT
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ asset('/images/rain64.png') }}" style="max-height:24px; max-width:100%"> : <b>ฝนตกภายในพื้นอุปกรณ์IoT</b>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-xs btn-danger"><span class="fa fa-cloud"></span></button>
                        : <b>มีโอกาสฝนตกภายในพื้นอุปกรณ์IoT</b>
                    </div>
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-2">
                        {!! Form::open(['method' => 'GET','url'=>'/user/devices','class'=>'','role','search' ])!!}
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
                @if($devices->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-0">
                                @foreach ($devices as $device)
                                    <div class="box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <img class="img-responsive img-circle"
                                                             src="{{ ($device->weather->count() > 0) ? ($device->weather->last()->rain == 1) ? asset('/images/rain128.png') : asset('/images/cloud128.png') : asset('/images/noneCloud.png') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <h4>{{ $device->SerialNumber }}
                                                            <small> อัพเดทล่าสุด
                                                                : {{ $device->updated_at->diffForHumans(Carbon\Carbon::now()) }}</small>
                                                        </h4>
                                                    </div>
                                                    <div class="form-group">
                                                        @if($device->weather()->count()>0 && !is_null($device->weather->last()->PredictPercent))
                                                            @if($device->weather->last()->PredictPercent >= $device->threshold )
                                                                <button class="btn btn-xs btn-danger">
                                                                    <span class="fa fa-cloud"></span> {{  $device->weather->last()->PredictPercent }}
                                                                    %
                                                                </button>
                                                            @else
                                                                <button class="btn btn-xs btn-success">
                                                                    <span class="fa fa-cloud"></span> {{  $device->weather->last()->PredictPercent }}
                                                                    %
                                                                </button>
                                                            @endif
                                                        @else
                                                            <button class="btn btn-xs disabled">
                                                                <span class="fa fa-cloud"></span>
                                                            </button>
                                                        @endif
                                                        <span style="display: inline; margin-left: 10px">
                                                        ตำแหน่งล่าสุด :
                                                            @if(!(empty($device->latitude) || empty($device->longitude)))
                                                                {{ \Geocode::make()->latLng($device->latitude, $device->longitude)->formattedAddress() }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <a class="btn btn-blue btn-block"
                                                           href="{{  url('/user/devices/'.$device->id)}}">
                                                            <span class="fa fa-eye"></span> ดูรายละเอียด
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <button class="btn btn-blue btn-block"
                                                                href="{{ url('/user/map/full?SerialNumber='.$device->SerialNumber.'&latitude='.$device->latitude.'&longitude='.$device->longitude)}}"
                                                                data-lity>
                                                            <span class="fa fa-globe"></span> ตำแหน่งบนแผนที่
                                                        </button>
                                                    </div>
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
                @else
                    <div class="title">ไม่พบข้อมูล
                        <h1>รายการอุปกรณ์ IoT</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
