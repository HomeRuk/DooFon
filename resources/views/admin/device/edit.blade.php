@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h3>แก้ไขรายการอุปกรณ์IoT</h3></div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! Form::model($device , array('url' => '/admin/devices/'.$device->id,'method' => 'PATCH','id' => 'update')) !!}

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
    </div>
@endsection

@section('footer')
    <script>
        $("#update").on("submit", function () {
            return confirm("คุณต้องการปรับปรุงรายการอุปกรณ์IoT นี้ใช้หรือไม่");
        });
    </script>
@endsection

