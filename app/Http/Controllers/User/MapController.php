<?php

namespace App\Http\Controllers\User;

use App\Device;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mapper;
use Geocode;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{

    public function index()
    {
        $devices = User::findOrFail(Auth::user()->id)->device()->get();
        try {
            Mapper::map(0, 0, ['zoom' => '6', 'center' => false, 'marker' => false]);
            foreach ($devices as $device) {
                $response = Geocode::make()->latLng($device->latitude, $device->longitude);
                $content = '<b>' . $device->SerialNumber . '</b><br/>';
                $rain = $device->weather->last()->rain;
                if ($response) {
                    if ($rain == 1) {
                        Mapper::informationWindow($device->latitude, $device->longitude, $content . $response->formattedAddress(), [
                            'open' => true,
                            'eventClick' => 'window.location.href = \'' . url('/user/devices/' . $device->id) . '\'',
                            'icon' => url('/images/rain64.png')
                        ]);
                    } else {
                        Mapper::informationWindow($device->latitude, $device->longitude, $content . $response->formattedAddress(), [
                            'open' => true,
                            'eventClick' => 'window.location.href = \'' . url('/user/devices/' . $device->id) . '\'',
                            'icon' => url('/images/cloud64.png')
                        ]);
                    }
                } else {
                    Mapper::informationWindow($device->latitude, $device->longitude, $content, ['open' => true]);
                }
            }
        } catch (\Exception $e) {

        }
        return view('user.map.index');
    }

    public function mapFull(Request $request)
    {
        $SerialNumber = $request->get('SerialNumber');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        if (empty($SerialNumber) || empty($latitude) || empty($longitude)) {
            return view('errors.404-2');
        } else {
            try {
                $response = Geocode::make()->latLng($latitude, $longitude);
                $content = '<b>' . $SerialNumber . '</b><br/>';
                if ($response) {
                    Mapper::map($latitude, $longitude, ['zoom' => '16', 'marker' => false, 'center' => true]);
                    Mapper::informationWindow($latitude, $longitude, $content . $response->formattedAddress(), ['open' => true, 'icon' => url('/images/rain64.png')]);
                } else {
                    Mapper::map($latitude, $longitude, ['zoom' => '16', 'marker' => false, 'center' => true]);
                    Mapper::informationWindow($latitude, $longitude, $content, ['open' => true, 'icon' => url('/images/rain64.png')]);
                }
            } catch (\Exception $e) {
                return view('errors.404-2');
            }
        }
        return view('user.map.full');
    }
}