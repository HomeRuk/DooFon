@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Device</div>

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

                    {!! Form::open(array('url' => 'device')) !!}

                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('SerialNumber', 'SerialNumber')  }}
                            {{ Form::text('SerialNumber',null,['class' => 'form-control','placeholder'=>'Ex. AsZsXsweRq']) }}
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            {{ Form::label('address', 'address')  }}
                            {{ Form::text('address',null,['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('latitude', 'latitude')  }}
                            {{ Form::text('latitude',null,['class' => 'form-control','placeholder'=>'Ex. 101.123456']) }}
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('longitude', 'longitude')  }}
                            {{ Form::text('longitude',null,['class' => 'form-control','placeholder'=>'Ex. 101.123456']) }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('threshold', 'threshold')  }}
                            {{ Form::number('threshold',null,['class' => 'form-control','placeholder'=>'Ex. 70']) }}
                        </div>
                    </div>
                    
                    <div class="col-sm-10">
                        <div class="form-group">
                            {{ Form::submit('Save',['class' => 'btn btn-primary']) }}
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

@if (session()->has('status')) 

<script>
    swal({
        title: '<?php echo session()->get('status'); ?>',
        text: 'ผลการทำงาน',
        type: 'success',
        timer: 2000
    })
</script>

@endif
@if (count($errors) > 0)

<script>
    swal({
        title: 'ผิดพลาด',
        text: 'กรุณาตรวจสอบการกรอกข้อมูล',
        type: 'error',
        timer: 2000
    })
</script>

@endif

@endsection

