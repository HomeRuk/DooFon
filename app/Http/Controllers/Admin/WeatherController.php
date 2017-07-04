<?php

namespace App\Http\Controllers\Admin;

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
            $countW = Weather::count();
            $tempWeather = DB::select('SELECT temp AS temperature, created_at AS timeweather FROM weather');
            $humidityWeather = DB::select('SELECT humidity, created_at AS timeweather FROM weather');
            $dewpointWeather = DB::select('SELECT dewpoint, created_at AS timeweather FROM weather');
            $pressureWeather = DB::select('SELECT pressure, created_at AS timeweather FROM weather');
            $lightWeather = DB::select('SELECT light, created_at AS timeweather FROM weather');
            $rainWeather = DB::select('SELECT rain, created_at AS timeweather FROM weather');
        } else {
            $countW = Weather::where('devices_id', '=', $device_id)->count();
            $tempWeather = DB::select('SELECT temp AS temperature, created_at AS timeweather FROM weather WHERE devices_id = ? ', [$device_id]);
            $humidityWeather = DB::select('SELECT humidity, created_at AS timeweather FROM weather WHERE devices_id = ? ', [$device_id]);
            $dewpointWeather = DB::select('SELECT dewpoint, created_at AS timeweather FROM weather WHERE devices_id = ? ', [$device_id]);
            $pressureWeather = DB::select('SELECT pressure, created_at AS timeweather FROM weather WHERE devices_id = ? ', [$device_id]);
            $lightWeather = DB::select('SELECT light, created_at AS timeweather FROM weather WHERE devices_id = ? ', [$device_id]);
            $rainWeather = DB::select('SELECT rain, created_at AS timeweather FROM weather WHERE devices_id = ? ', [$device_id]);
        }
        return view('admin.weather.report', [
            'countW' => $countW,
            'tempWeathers' => $tempWeather,
            'humidityWeathers' => $humidityWeather,
            'dewpointWeathers' => $dewpointWeather,
            'pressureWeathers' => $pressureWeather,
            'lightWeathers' => $lightWeather,
            'rainWeathers' => $rainWeather,
        ]); //admin/weather/report.blade.php
    }
}
