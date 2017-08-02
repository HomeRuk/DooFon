@extends('layouts.admin.app')
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
                                <a href="#" class="btn btn-blue add-device">
                                    <span class="fa fa-plus-circle"></span> สร้างรายการอุปกรณ์IoT
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <img src="{{ asset('/images/rain64.png') }}" style="max-height:24px; max-width:100%"> : <b>ฝนตกภายในพื้นอุปกรณ์IoT</b>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button class="btn btn-xs btn-danger"><span class="fa fa-cloud"></span></button>
                            : <b>มีโอกาสฝนตกภายในพื้นอุปกรณ์IoT</b>
                        </div>
                    </div>
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-2">
                        {!! Form::open(['method' => 'GET','url'=>'/admin/devices','role','search' ])!!}
                        <div class="input-group custom-search-form">
                            <input type="search" name="search" class="form-control" placeholder="ค้นหา SerialNumber">
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
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                                                        <img class="img-responsive img-circle center-block"
                                                             src="{{ ($device->weather->count() > 0) ? ($device->weather->last()->rain == 1) ? asset('/images/rain128.png') : asset('/images/cloud128.png') : asset('/images/noneCloud.png') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <h4>
                                                            {{ $device->SerialNumber }}
                                                            <small> อัพเดทล่าสุด
                                                                : {{ $device->updated_at->diffForHumans(Carbon\Carbon::now()) }}
                                                                @if($device->id === $deviceIdNew)
                                                                    <img class="img-responsive img-circle" width="32px" style="display: inline" src="{{ asset('/images/new.svg') }}"/>
                                                                @endif
                                                            </small>
                                                        </h4>
                                                    </div>
                                                    <div class="form-group">
                                                        @if(($device->weather()->count()>0) && ($device->weather->last()->PredictPercent != null ))
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
                                                           href="{{  url('/admin/devices/'.$device->id)}}">
                                                            <span class="fa fa-eye"></span> ดูรายละเอียด
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <button class="btn btn-blue btn-block"
                                                                href="{{ ($device->weather->count() > 0) ? url('/admin/map/full?SerialNumber='.$device->SerialNumber.'&latitude='.$device->latitude.'&longitude='.$device->longitude.'&rain='.$device->weather->last()->rain) : url('/admin/map/full?SerialNumber='.$device->SerialNumber.'&latitude='.$device->latitude.'&longitude='.$device->longitude)}}"
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

    <!-- Modal form to Create a device -->
    <div id="addDevice" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">เพิ่มอุปกรณ์IoT</h3>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('url' => '/admin/devices' ,'method' => 'POST' ,'id' => 'save')) !!}
                    <div class="col-md-11">
                        <div class="form-group">
                            {{ Form::label('SerialNumber', 'SerialNumber') }}
                            {{ Form::text('SerialNumber',null,['class' => 'form-control input-lg','placeholder'=>'Ex. AsZsXsweRq','pattern'=>'[0-9a-zA-Z]{10}','title'=>'กรุณากรอกตัวเลขหรือตัวอักษรภาษาอังกฤษรวม 10 หลัก','required autofocus']) }}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h2><i class="fa fa-refresh" onclick="makeSerialNumber()"></i></h2>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('threshold', 'threshold')  }}
                            {{ Form::number('threshold',null,['class' => 'form-control input-lg','placeholder'=>'Ex. 70','required','min'=>'1','max'=>'100']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::submit('สร้าง',['class' => 'btn btn-lg btn-primary btn-block']) }}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!-- jQuery operations -->
    <script type="text/javascript" src="{{ asset('js/jQueryDevice.js') }}"></script>

    <script>
        $(document).ready(makeSerialNumber());
        function makeSerialNumber() {
            var SerialNumber = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 10; i++) {
                SerialNumber += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            document.getElementById("SerialNumber").value = SerialNumber;
            return false;
        }
    </script>
@endsection
