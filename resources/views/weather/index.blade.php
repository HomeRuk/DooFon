@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-custom-horrible-blue">
                    <div class="panel-heading"><h4>Lists Weather {{ $Weathers->total() }} list</h4></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="active">
                                    <th>ลำดับ</th>
                                    <th>อุณหภูมิ</th>
                                    <th>ความชื้น</th>
                                    <th>อุณหภูมจุดน้ำค้าง</th>
                                    <th>ความกดอากาศ</th>
                                    <th>ความสว่าง</th>
                                    <th>ค่าฝน</th>
                                    <th>ค่าพยากรณ์ฝน%</th>
                                    <th>ชื่อโมเดลในการพยากรณ์</th>
                                    <th>SerialNumber</th>
                                    <th>อัพเดทล่าสุด</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($Weathers as $Weather)
                                    <tr>
                                        <td>{{ $Weather->id }}</td>
                                        <td>{{ $Weather->temp }}</td>
                                        <td>{{ $Weather->humidity }}</td>
                                        <td>{{ $Weather->dewpoint }}</td>
                                        <td>{{ $Weather->pressure }}</td>
                                        <td>{{ $Weather->light }} </td>
                                        <td>{{ $Weather->rain }} </td>
                                        <td>
                                            @if(!empty($Weather->PredictPercent))
                                                {{ $Weather->PredictPercent }}
                                            @else
                                                <div style="text-align: center;">-</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($Weather->model_id))
                                                <a href="{{ url('model_predict/'.$Weather->modelpredict->id) }}">{{ $Weather->modelpredict->modelname}}</a>
                                            @else
                                                <div style="text-align: center;">-</div>
                                            @endif
                                        </td>
                                        <td>{{ $Weather->SerialNumber }}</td>
                                        <td>{{ $Weather->updated_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $Weathers->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<?php
/*
  $arff = "@relation SerialNumber\r\n@attribute temp numeric\r\n@attribute humidity numeric\r\n@attribute dewpoint numeric\r\n@attribute pressure numeric\r\n@attribute light numeric\r\n@attribute rain {0, 1}\r\n\r\n@data\r\n";

  $file = new SplFileObject('file.arff', 'w');
  $file->fwrite($arff);
  foreach ($Weathers as $Weather) {
  $list2 = get_object_vars($Weather);
  $file->fputcsv($list2);
  dump($list2);
  } */
?>


