@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading"><h4>Lists Weather {{ $count }} list</h4></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="active">
                                    <th>id</th>
                                    <th>temp</th>
                                    <th>humidity</th>
                                    <th>dewpoint</th>
                                    <th>pressure</th>
                                    <th>light</th>
                                    <th>rain</th>
                                    <th>Predict%</th>
                                    <th>Modelname</th>
                                    <th>SerialNumber</th>
                                    <th>updated_at</th>
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
                                    <td>{{ $Weather->PredictPercent }}</td>
                                    <td><a href="{{ url('model_predict/'.$Weather->model_id) }}">{{ $Weather->modelpredict->modelname}}</a></td>
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


