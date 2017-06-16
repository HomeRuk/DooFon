@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading"><h4> Device จำนวน {{ $count }} เครื่อง</h4></div>      
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"> 
                            <thead>
                                <tr class="active">
                                    <th>SerialNumber</th>
                                    <th>latitude</th>
                                    <th>longitude</th>
                                    <th>Threshold</th>
                                    <th>Mode</th>
                                    <th>Updated_at</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($devices as $device)
                                <tr>
                                    <td>{{ $device->SerialNumber }}</td>
                                    <td>{{ $device->latitude }}</td>
                                    <td>{{ $device->longitude }}</td>
                                    <td>{{ $device->threshold }}</td>
                                    <td>{{ $device->mode }} hr</td>
                                    <td>{{ $device->updated_at }} </td>
                                    <td>
                                        <div style="vertical-align: middle;">
                                            <a class="btn btn-warning" href="{{ url('device/'.$device->SerialNumber.'/edit') }}"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                    <td>
                                        {!! Form::open(array('url' => 'device/'.$device->SerialNumber,'method' => 'delete')) !!} 
                                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $devices->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
