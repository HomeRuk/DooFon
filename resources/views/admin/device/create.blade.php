@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h3>สร้างรายการอุปกรณ์IoT</h3></div>
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
                            <hr/>
                            <div class="form-group">
                                {{ Form::submit('สร้าง',['class' => 'btn btn-lg btn-primary btn-block']) }}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $("#save").on("submit", function () {
            return confirm("คุณต้องการสร้างรายการอุปกรณ์IoTนี้ใช้หรือไม่");
        });
    </script>

    <script>
        $(document).ready(makeSerialNumber());
        function makeSerialNumber() {
            var SerialNumber = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 10; i++) {
                SerialNumber += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            //document.getElementById("SerialNumber").value =  (Math.random()+1).toString(36).substr(2, 10);
            document.getElementById("SerialNumber").value = SerialNumber;
            return false;
        }
    </script>
@endsection

