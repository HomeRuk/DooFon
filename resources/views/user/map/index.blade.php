@extends('layouts.user.app_map')
@section('content')

<div id="map">{!! Mapper::render(0) !!}</div>

@endsection
