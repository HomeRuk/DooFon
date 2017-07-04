@extends('layouts.admin.app_map')
@section('content')

<div id="map">{!! Mapper::render(0) !!}</div>

@endsection
