<?php

namespace App\Http\Controllers\User;

use App\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// model 
use App\Weather;
use Illuminate\Support\Facades\DB;

class WeatherController extends Controller
{
    public function chartReport(Request $request)
    {
        $device_id = $request->get('device_id');
        if (empty($device_id)) {
            return abort(404);
        } else {
            try {
                $device = Device::findOrFail($device_id);
                $countW = Weather::where('devices_id', '=', $device_id)->count();
                $tempWeather = DB::select('SELECT temp AS temperature, created_at AS timeweather FROM weathers WHERE devices_id = ? ', [$device_id]);
                $humidityWeather = DB::select('SELECT humidity, created_at AS timeweather FROM weathers WHERE devices_id = ? ', [$device_id]);
                $dewpointWeather = DB::select('SELECT dewpoint, created_at AS timeweather FROM weathers WHERE devices_id = ? ', [$device_id]);
                $pressureWeather = DB::select('SELECT pressure, created_at AS timeweather FROM weathers WHERE devices_id = ? ', [$device_id]);
                $lightWeather = DB::select('SELECT light, created_at AS timeweather FROM weathers WHERE devices_id = ? ', [$device_id]);
                $rainWeather = DB::select('SELECT rain, created_at AS timeweather FROM weathers WHERE devices_id = ? ', [$device_id]);
            }catch (\Exception $e) {
                return abort(404);
            }
        }
        return view('user.weather.report', [
            'device' => $device,
            'countW' => $countW,
            'tempWeathers' => $tempWeather,
            'humidityWeathers' => $humidityWeather,
            'dewpointWeathers' => $dewpointWeather,
            'pressureWeathers' => $pressureWeather,
            'lightWeathers' => $lightWeather,
            'rainWeathers' => $rainWeather,
        ]); //user/weather/report.blade.php
    }
}
