@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-10">
                        <span class="fa fa-database fa-5x"></span>
                        <span style="font-size:38px; margin-left: 2%">รายการโมเดลพยากรณ์ฝนตก</span>
                    </div>
                    <div class="col-md-2">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <br>
                            <a href="{{ url('/model_predicts/create') }}" class="btn btn-blue">
                                <span class="fa fa-plus-circle"></span> Create Model
                            </a>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        {!! Form::open(['method' => 'GET','url'=>'/model_predicts','class'=>'','role','search' ])!!}
                        <div class="input-group custom-search-form">
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา ชื่อโมเดล">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default-sm">
                                <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="row">
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
                                        <td>
                                            <a href="{{ url('/model_predicts/'.$model->id) }}">{{ $model->modelname }}</a>
                                        </td>
                                        <td>2 hr</td>
                                        <td>{{ $model->model }}</td>
                                        <td>{{ $model->exetime }} sec</td>
                                        <td>{{ $model->created_at }} </td>
                                        <td>
                                            {!! Form::open(array('url' => '/model_predicts/'.$model->id,'method' => 'delete')) !!}
                                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
