@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ url('model_predict/create') }}" class="btn btn-lg btn-primary btn-block">Create Model</a> 
            <hr/>
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading">
                    <h4>Prediction Model Weather จำนวน {{ $models->total() }} โมเดล</small></h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"> 
                            <thead>
                                <tr class="active">
                                    <th>Id</th>
                                    <th>ModelName</th>
                                    <th>Mode</th>
                                    <th>Model</th>
                                    <th>ExecuteTime</th>
                                    <th>Create_at</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($models as $model)
                                <tr>
                                    <td>{{ $model->id }}</td>
                                    <td><a href="{{ url('model_predict/'.$model->id) }}">{{ $model->modelname }}</a></td>
                                    <td>2 hr</td>
                                    <td>{{ $model->model }}</td>
                                    <td>{{ $model->exetime }} sec</td>
                                    <td>{{ $model->created_at }} </td>
                                    <td>
                                        {!! Form::open(array('url' => 'model_predict/'.$model->id,'method' => 'delete')) !!}
                                        <button class="btn btn-danger" ><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $models->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection