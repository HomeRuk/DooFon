@extends('layouts.admin.app')

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
                            <a href="{{ url('/admin/model_predicts/create') }}" class="btn btn-blue">
                                <span class="fa fa-plus-circle"></span> สร้างโมเดลพยากรณ์
                            </a>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        {!! Form::open(['method' => 'GET','url'=>'/admin/model_predicts','class'=>'','role','search' ])!!}
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
                @if($models->count() > 0)
                    <div class="row">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="active">
                                        <th>รหัส</th>
                                        <th>ชื่อโมเดล</th>
                                        <th>ชื่ออัลกอริทึม</th>
                                        <th>เวลาสร้าง</th>
                                        <th>เพิ่มเติม</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($models as $model)
                                        <tr>
                                            <td>{{ $model->id }}</td>
                                            <td>{{ $model->modelname }}</td>
                                            <td>{{ $model->model }}</td>
                                            <td>{{ $model->exetime }} sec</td>
                                            <td>
                                                <div style="display: inline;">
                                                    <a href="{{ url('/admin/model_predicts/'.$model->id) }}">
                                                        <button class="btn btn-blue"><i class="fa fa-eye"></i></button>
                                                    </a>
                                                    {!! Form::open(array('url' => '/admin/model_predicts/'.$model->id,'method' => 'delete','style' => 'display: inline;','id' => 'delete' )) !!}
                                                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $models->render() !!}
                        </div>
                    </div>
                @else
                    <div class="title">ไม่พบข้อมูล
                        <h1>รายการโมเดลพยากรณ์ฝนตก</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $("#delete").on("submit", function () {
            return confirm("คุณต้องการลบรายการโมเดลพยากรณ์ฝนตกนี้ ใช้หรือไม่");
        });
    </script>
@endsection

