@extends('layouts.user.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-12">
                        <span class="fa fa-mobile fa-5x"></span>
                        <span style="font-size:38px; margin-left: 2%">รายละเอียด</span>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <img class="img-responsive img-circle"
                                             src="{{ ($device->weather->count() > 0) ? ($device->weather->last()->rain == 1) ? asset('/images/rain128.png') : asset('/images/cloud128.png') : asset('/images/noneCloud.png') }}"">

                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                        ตำแหน่งล่าสุด : {{ $address }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if($device->weather()->count()>0)
                                        <div>
                                            <h4>สถาพอากาศล่าสุด</h4>
                                            <button class="btn btn-sm" style="display: inline;">
                                                <span class="fa fa-thermometer-empty"></span> {{ $device->weather->last()->temp }}
                                                °C
                                            </button>
                                            <button class="btn btn-sm" style="display: inline;">
                                                <img src="{{ asset('/images/humidity.png') }}"
                                                     style="max-height:14px; max-width:100%"></span> {{ $device->weather->last()->humidity }}
                                                %
                                            </button>
                                            <button class="btn btn-sm" style="display: inline;">
                                                <span class="fa fa-tint"></span> {{ $device->weather->last()->dewpoint }}
                                                °C
                                            </button>
                                            <button class="btn btn-sm">
                                                <span class="fa fa-tachometer"></span> {{ $device->weather->last()->pressure }}
                                                hPa
                                            </button>
                                            <button class="btn btn-sm">
                                                <span class="fa fa-lightbulb-o"></span> {{ $device->weather->last()->light }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button class="btn btn-blue btn-block"
                                                    href="{{ ($device->weather->count() > 0) ? url('/user/map/full?SerialNumber='.$device->SerialNumber.'&latitude='.$device->latitude.'&longitude='.$device->longitude.'&rain='.$device->weather->last()->rain) : url('/user/map/full?SerialNumber='.$device->SerialNumber.'&latitude='.$device->latitude.'&longitude='.$device->longitude)}}"
                                                    data-lity>
                                                <span class="fa fa-globe"></span> ตำแหน่งบนแผนที่
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a class="btn btn-blue btn-block"
                                               href="{{ url('/user/report?device_id='.$device->pivot->device_id) }}">
                                                <span class="fa fa-cloud"></span> กราฟรายงานสภาพอากาศ
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a class="btn btn-sm btn-warning btn-block edit-device" href="#">
                                                <span class="fa fa-pencil"></span> แก้ไข
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a class="btn btn-sm btn-danger btn-block del-device" href="#">
                                                <span class="fa fa-trash"></span> ลบ
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                @if($dWeathers->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <span class="fa fa-history fa-4x"></span>
                            <span style="font-size:38px; margin-left: 2%">ประวัติสภาพอากาศ</span>
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
                                        <th>อุณหภูมิ °C</th>
                                        <th>ความชื้น %</th>
                                        <th>อุณหภูมิจุดน้ำค้าง °C</th>
                                        <th>ความกดอากาศ hPa</th>
                                        <th>ความสว่าง</th>
                                        <th>ค่าฝน (ตก,ไม่ตก)</th>
                                        <th>ค่าพยากรณ์ฝน%</th>
                                        <th>ชื่อโมเดลพยากรณ์</th>
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
                                            <td>
                                                @if($dWeather->rain == 1)
                                                    <div style="text-align: center;">ตก</div>
                                                @elseif($dWeather->rain == 0)
                                                    <div style="text-align: center;">ไม่ตก</div>
                                                @else
                                                    <div style="text-align: center;">-</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($dWeather->PredictPercent))
                                                    {{ $dWeather->PredictPercent }}
                                                @else
                                                    <div style="text-align: center;">-</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($dWeather->model_id))
                                                    <a href="{{ url('/user/model_predicts/'.$dWeather->modelpredict->id) }}">{{ $dWeather->modelpredict->modelname}}</a>
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
                @else
                    <div class="title">ไม่พบข้อมูล<br/>
                        <h1>สภาพอากาศ</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal form to update a device -->
    <div id="editDevice" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">แก้ไขอุปกรณ์IoT</h3>
                </div>
                <div class="modal-body">
                    {!! Form::model($device , array('url' => '/user/devices/'.$device->id,'method' => 'PATCH','id' => 'update')) !!}
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('SerialNumber', 'SerialNumber') }}
                            {{ Form::text('SerialNumber',null,['class' => 'form-control input-lg','placeholder'=>'Ex. AsZsXsweRq','pattern'=>'[0-9a-zA-Z]{10}','title'=>'กรุณากรอกตัวเลขหรือตัวอักษรภาษาอังกฤษรวม 10 หลัก','required','disabled']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('latitude', 'latitude')  }}
                            {{ Form::text('latitude',null,['class' => 'form-control input-lg','placeholder'=>'Ex. 101.123456','required']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('longitude', 'longitude')  }}
                            {{ Form::text('longitude',null,['class' => 'form-control input-lg','placeholder'=>'Ex. 101.123456','required']) }}
                        </div>
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
                            {{ Form::submit('ปรับปรุง',['class' => 'btn btn-lg btn-primary btn-block','id' => 'update']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal form to delete a device -->
    <div id="delDevice" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">คุณต้องการลบรายการอุปกรณ์IoT นี้ใช้หรือไม่ ?</h3>
                </div>
                <div class="modal-body">
                    <label>SerialNumber : </label>
                    <input type="text" class="form-control input-lg" disabled value="{{ $device->SerialNumber }}">
                </div>
                <div class="modal-footer">
                    {!! Form::open(array('url' => '/user/devices/'.$device->pivot->device_id,'method' => 'delete','style'=>'display:inline','id' => 'delete')) !!}
                    <button class="btn btn-md btn-danger btn-block">
                        <span class="fa fa-trash"></span> ยืนยันการลบ
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')

    <script>
        $("#delete").on("submit", function () {
            return confirm("คุณต้องการลบรายการอุปกรณ์IoT นี้ใช้หรือไม่");
        });
    </script>

    <!-- jQuery operations -->
    <script type="text/javascript" src="{{ asset('js/jQueryDevice.js') }}"></script>
@endsection
