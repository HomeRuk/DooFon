@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading"><h4>Detail Model Weather</h4></div>      
                <div class="panel-body">
                    <div class="col-md-12 well well-sm">
                        <div class="col-md-6">
                            <h4><b>Name: </b> {{$model->modelname}}</h4>
                            <h4><b>Mode: </b>{{$model->mode}} Hour</h4>
                            <h4><b>Model: </b>{{$model->model}}</h4>
                            <h4><b>ExecuteTime: </b>{{$model->exetime}} sec</h4>
                            <h4><b>Create_at: </b> {{$model->created_at}}</h4>
                            <h4><b>Updated_at: </b> {{$model->updated_at}}</h4>
                        </div>
                        <div class="col-md-6">
                            <p><a href="{{ url('/model_predict/download/arff/'.$model->id) }}" class="btn btn-info btn-block"><b>Download Data/Arff</b></a></p>
                            <p><a href="{{ url('/model_predict/download/model/'.$model->id) }}" class="btn btn-info btn-block"><b>Download Model</b></a></p>
                            <p><a href="{{ url('/model_predict/download/txt/'.$model->id) }}" class="btn btn-success btn-block"><b>Download Plain/Text</b></a></p>
                            <p><a href="{{ url('/model_predict/download/pdf/'.$model->id) }}" class="btn btn-success btn-block"><b>Download PDF</b></a></p>
                            <p><a href="{{ url('/model_predict/stream/pdf/'.$model->id) }}" class="btn btn-success btn-block"><b>Stream PDF</b></a></p> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4><u><b>Results Model</b></u></h4>
                        @foreach($texts as $text)
                        {{$text}}<br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
