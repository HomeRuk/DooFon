@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h4>รายละเอียดโมเดลพยากรณ์ฝนตก</h4></div>
                    <div class="panel-body">
                        <div class="col-md-12 well well-sm">
                            <div class="col-md-8">
                                <h4><b>ชื่อโมเดล : </b> {{$model->modelname}}</h4>
                                <h4><b>โหมด : </b> {{ $model->mode }} 2 Hour</h4>
                                <h4><b>ชื่ออัลกอริทึม : </b> {{$model->model}}</h4>
                                <h4><b>ดำเนินการพยากรณ์โมเดล : </b> {{$model->exetime}} sec</h4>
                                <h4><b>วันเวลาที่สร้าง : </b> {{$model->created_at}}</h4>
                                <h4><b>วันเวลาที่แก้ไข : </b> {{$model->updated_at}}</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="strike">
                                    <span><b>ข้อมูลของโมเดล</b></span>
                                </div>
                                <p><a href="{{ url('/admin/model_predict/download/arff/'.$model->id) }}"
                                      class="btn btn-blue btn-block"><b>ดาวน์โหลด Data/Arff</b></a></p>
                                <p><a href="{{ url('/admin/model_predict/download/model/'.$model->id) }}"
                                      class="btn btn-blue btn-block"><b>ดาวน์โหลด Model</b></a></p>
                                <div class="strike">
                                    <span><b>ผลลัพท์ของโมเดล</b></span>
                                </div>
                                <p><a href="{{ url('/admin/model_predict/download/txt/'.$model->id) }}"
                                      class="btn btn-success btn-block"><b>ดาวน์โหลด Plain/Text</b></a></p>
                                <p><a href="{{ url('/admin/model_predict/download/pdf/'.$model->id) }}"
                                      class="btn btn-success btn-block"><b>ดาวน์โหลด PDF</b></a></p>
                                <p><a href="{{ url('/admin/model_predict/stream/pdf/'.$model->id) }}"
                                      class="btn btn-success btn-block"><b>Stream PDF</b></a></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h4><u><b>ผลลัพท์ของโมเดล</b></u></h4>
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