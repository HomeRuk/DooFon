@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-custom-horrible-blue">
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


                    <div class="col-md-11">
                        <div class="form-group">
                            {{ Form::label('SerialNumber', 'SerialNumber') }}
                            {{ Form::text('SerialNumber',null,['class' => 'form-control input-lg','placeholder'=>'Ex. AsZsXsweRq','required autofocus']) }}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h2><i class="fa fa-refresh" onclick="makeSerialNumber()"></i></h2>
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
                            {{ Form::number('threshold',null,['class' => 'form-control input-lg','placeholder'=>'Ex. 70','required']) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::submit('Save',['class' => 'btn btn-lg btn-primary btn-block']) }}
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
    $(document).ready(makeSerialNumber());
    function makeSerialNumber()
    {
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

@endsection

