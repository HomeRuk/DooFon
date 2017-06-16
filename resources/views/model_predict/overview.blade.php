@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('model_predict/create') }}" class="btn btn-lg btn-primary btn-block">Create Model</a> 
            <hr/>
            <div class="panel panel-primary" >
                <div class="panel-heading"><h4>Model Overview</h4></div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-mobile fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <h3>{{ $count }}</h3>
                                        <h4>Model</h4>
                                    </div>
                                </div>
                            </div>
                             <a href="{{ url('/model_predict') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
