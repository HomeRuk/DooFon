@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ url('model_predict/create') }}" class="btn btn-lg btn-primary btn-block">Create Model</a> 
            <hr/>
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading"><h4>Prediction Model Weather</h4></div>      
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"> 
                            <thead>
                                <tr class="active">
                                    <th>Name</th>
                                    <th>Model</th>
                                    <th>Create_at</th>
                                    <th>Updated_at</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($models as $model)
                                <tr>
                                    <td><a href="{{ url('model_predict/'.$model->id) }}">{{ $model->file }}</a></td>
                                    <td>{{ $model->modelname }}</td>
                                    <td>{{ $model->updated_at }} </td>
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
