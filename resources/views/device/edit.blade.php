@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h3>Edit Device</h3></div>
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

                        {!! Form::model($device , array('url' => '/devices/'.$device->id,'method' => 'PATCH','id' => 'update')) !!}

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
                                {{ Form::submit('Save',['class' => 'btn btn-lg btn-primary btn-block','id' => 'update']) }}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
=======
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading">Edit Device</div>
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


                    {!! Form::model($devices, array('url' => 'device/'.$devices->SerialNumber ,'method' => 'PUT')) !!}
                   
                    <div class="col-md-11">
                        <div class="form-group">
                            {{ Form::label('SerialNumber', 'SerialNumber') }}
                            {{ Form::text('SerialNumber',null,['class' => 'form-control input-lg','placeholder'=>'Ex. AsZsXsweRq','required autofocus','disabled']) }}
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
<!--
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('mode(2Hour)', 'mode(2Hour)')  }}
                            {{ Form::number('mode',null,['class' => 'form-control input-lg','placeholder'=>'Ex. 2','required','disabled']) }}
                        </div>
                    </div>
-->
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::submit('Save',['class' => 'btn btn-lg btn-primary btn-block']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
>>>>>>> master
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
@endsection

@section('footer')
    <script>
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

    @if (session()->has('status'))
        <script>
            swal({
                title: '{{ session()->get('status') }}',
                text: 'Save success',
                type: 'success',
                timer: 2000
            });
        </script>
    @endif
    @if (count($errors) > 0)
        <script>
            swal({
                title: 'Error',
                text: 'Please Check Data',
                type: 'error',
                timer: 2000
            });
        </script>
    @endif
=======
</div>
@endsection

@section('footer')

@if (session()->has('status')) 

<script>
    swal({
        title: '{{ session()->get('status') }}',
        text: 'Save success',
        type: 'success',
        timer: 2000
    });
</script>

@endif
@if (count($errors) > 0)

<script>
    swal({
        title: 'Error',
        text: 'Please Check Data',
        type: 'error',
        timer: 2000
    });
</script>

@endif
>>>>>>> master

@endsection

