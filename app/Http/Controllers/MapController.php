<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Mapper;
use Geocode;
use App\Http\Requests;

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $devices = Device::all();
        Mapper::map(13.778797, 100.560264, ['zoom' => '6', 'minZoom' => '0', 'maxZoom' => '15','draggable' => true]);

        foreach ($devices as $device) {
            //Mapper::marker($device->latitude, $device->longitude,['title' => $device->SerialNumber ]);
            $response = Geocode::make()->latLng($device->latitude, $device->longitude);
            $content = '<b>'.$device->SerialNumber.'</b><br/>';
            if ($response) {
                Mapper::informationWindow($device->latitude, $device->longitude, $content.$response->formattedAddress() , ['open' => true, 'maxWidth' => 300, 'eventClick' => 'alert("left click");']);
            } else {
                Mapper::informationWindow($device->latitude, $device->longitude, $content, ['open' => true, 'maxWidth' => 300, 'eventClick' => 'alert("left click");']);
            }
        }

        $response = Geocode::make()->latLng(13.778797, 100.560264);
        if ($response) {
            // echo $response->formattedAddress();
        }
        return view('map.index');
    }
}