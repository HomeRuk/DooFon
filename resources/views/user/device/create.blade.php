@extends('layouts.user.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h3>เพิ่มรายการอุปกรณ์IoT</h3></div>
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

                        {!! Form::open(array('url' => '/user/devices','method' => 'POST' ,'id' => 'save')) !!}

                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('SerialNumber', 'SerialNumber') }}
                                {{ Form::text('SerialNumber',null,['class' => 'form-control input-lg','placeholder'=>'Ex. AsZsXsweRq','pattern'=>'[0-9a-zA-Z]{10}','title'=>'กรุณากรอกตัวเลขหรือตัวอักษรภาษาอังกฤษรวม 10 หลัก','required autofocus']) }}
                            </div>
                        </div>
                            <hr/>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::submit('เพิ่ม',['class' => 'btn btn-lg btn-primary btn-block']) }}
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
        $("#save").on("submit", function () {
            return confirm("คุณต้องการเพิ่มรายการอุปกรณ์IoTนี้ใช้หรือไม่");
        });
    </script>
@endsection

