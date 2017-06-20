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

    public function index(Request $request)
    {
        $devices = Device::all();

        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        if (empty($latitude) || empty($longitude)) {
            Mapper::map(0, 0, ['zoom' => '6', 'center' => false, 'marker' => false]);
            foreach ($devices as $device) {
                //Mapper::marker($device->latitude, $device->longitude,['title' => $device->SerialNumber ]);
                $response = Geocode::make()->latLng($device->latitude, $device->longitude);
                $content = '<b>' . $device->SerialNumber . '</b><br/>';
                if ($response) {
                    Mapper::informationWindow($device->latitude, $device->longitude, $content . $response->formattedAddress(), ['open' => true, 'maxWidth' => 300, 'eventClick' => 'alert("left click");']);
                } else {
                    Mapper::informationWindow($device->latitude, $device->longitude, $content, ['open' => true]);
                }
            }
        } else {
            Mapper::map($latitude, $longitude, ['zoom' => '17', 'minZoom' => '0', 'maxZoom' => '15']);
        }
        return view('map.index');
    }

    public function mapfull(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        if (empty($latitude) || empty($longitude)) {
            return abort(404);
        } else {
            $content = '<b>' . $latitude . ',' . $longitude . '</b><br/>';
            Mapper::map(0, 0, ['zoom' => '16', 'marker' => false, 'center' => false, 'maxZoom' => '16']);
            Mapper::informationWindow($latitude, $longitude, $content, ['open' => true , 'icon' => url('/images/humidity.png')]);
        }
        return view('map.full');
    }
}