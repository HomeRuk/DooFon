<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;

use App\Http\Requests\DeviceRequest;
use App\Http\Requests\DeviceLocationRequest;
use App\Http\Requests\DeviceThresholdRequest;
use App\Http\Requests\DeviceFCMtokenRequest;
use App\Device;
use App\Weather;
use DB;

class DeviceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'updateLocation', 'updateThreshold', 'updateFCMtoken', 'updateMode']]);
    }

    /**
     * Device Weather
     * URL Path : /Weathers
     * Method : GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //$device = Device::paginate(10);
        $searchSerialNumber = $request->get('search');
        $device = Device::where('SerialNumber','like','%'.$searchSerialNumber.'%')->orderBy('SerialNumber','asc')->paginate(10);
        return view('device.index', [
            'devices' => $device,
        ]);// Device/index.blade.php
    }

    /**
     * Overview Device
     * Display count,
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $count = Device::count();
        return view('device.overview', [
            'count' => $count,
        ]);// Device/overview.blade.php
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('device.create');// Device/create.blade.php
    }

    /**
     * Store Device
     * URL Path : /Devices
     * Method : POST
     * @param DeviceRequest $request
     * @internal param $App /Http/Requests/DeviceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeviceRequest $request)
    {
        $Device = new Device();
        $Device->create($request->all()); //$fillable
        $request->session()->flash('status', 'Save success');
        return back();
        //return redirect()->action('DeviceController@create');
    }

    public function edit($SerialNumber)
    {
        $device = Device::where('SerialNumber', '=', $SerialNumber)->first();
        if (empty($device)) {
            abort(404);
        }
        return view('device.edit', [
            'device' => $device,
        ]);
    }

    public function update(Request $request, $SerialNumber)
    {
        try {
            Device::where('SerialNumber', '=', $SerialNumber)->update(
                [
                    'threshold' => $request->threshold,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]
            );
        } catch (\Exception $e) {
        }
        return redirect()->action('DeviceController@index');
    }

    public function show($SerialNumber)
    {
        $device = Device::where('SerialNumber', '=', $SerialNumber)->first();
        $dWeather = Weather::where('SerialNumber', '=', $SerialNumber)->orderBy('id', 'asc')->paginate(50);
        //$lastWeather = Weather::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('device.show', [
            'device' => $device,
            'dWeathers' => $dWeather,
            //'lastWeather' => $lastWeather
        ]); // Device/get.blade.php
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy($SerialNumber)
    {
        //Remove row SerialNumber foreign key
        Device::where('SerialNumber', $SerialNumber)->delete();
        return redirect()->action('DeviceController@index');
    }

    public function getDevice($SerialNumber = null)
    {
        $Dserialnumber = Device::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('device.get', [
            'Dserialnumbers' => $Dserialnumber
        ]); // Device/get.blade.php
    }

    // Update Setting Location of Device
    public function updateLocation(DeviceLocationRequest $request)
    {
        $SerialNumber = $request->SerialNumber;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $sid = $request->sid;
        if ($sid == 'Ruk') {
            Device::where('SerialNumber', '=', $SerialNumber)->update(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]
            );
        }
    }

    // Update Setting Threshold of Device
    public function updateThreshold(DeviceThresholdRequest $request)
    {
        $SerialNumber = $request->SerialNumber;
        $threshold = $request->threshold;
        $sid = $request->sid;
        if ($sid == 'Ruk') {
            Device::where('SerialNumber', '=', $SerialNumber)->update(
                [
                    'threshold' => $threshold,
                ]
            );
        }
    }

    // Update FCMtoken Device to Database
    public function updateFCMtoken(DeviceFCMtokenRequest $request)
    {
        $SerialNumber = $request->SerialNumber;
        $FCMtoken = $request->FCMtoken;
        dump($request->FCMtoken);
        $sid = $request->sid;
        if (strlen($FCMtoken) < 100) $FCMtoken = NULL;
        if ($FCMtoken === '0') $FCMtoken = NULL;
        if ($sid == 'Ruk') {
            Device::where('SerialNumber', '=', $SerialNumber)->update(
                [
                    'FCMtoken' => $FCMtoken,
                ]
            );
        }
    }

    // Notification prediction rain
    public static function notifyPredict($SerialNumber, $outputPrediction)
    {
        $device = Device::where('SerialNumber', '=', $SerialNumber)->first();
        // Compare PercentRainCurrent vs SettingThresholdDevice
        if ($outputPrediction >= $device->threshold) {
            DeviceController::alert($SerialNumber, $outputPrediction);
        }
    }

    // Alert to device
    public static function alert($SerialNumber, $PredictPercent)
    {
        $FCMtokens = DB::select('SELECT FCMtoken FROM device WHERE SerialNumber = ? ', [$SerialNumber]);
        $api_url = "https://fcm.googleapis.com/fcm/send";
        $server_key = "key=AIzaSyD5QSI1ysohyLh8Yqv3Xcx6_SCsL8WJMLc";
        foreach ($FCMtokens as $FCMtoken) {
            $token_target = $FCMtoken->FCMtoken;
        }
        $color = "#4FC3F7";
        $title = "DooFon";
        $body = "$SerialNumber --> Probability Rain! $PredictPercent %";

        $json = "{
                    \"to\" : \"$token_target\",
                    \"collapse_key\" : \"DooFon\",    
                    \"priority\" : \"high\",
                    \"notification\" : {
                        \"body\"  : \"$body\",
                        \"title\" : \"$title\",
                        \"sound\"  : \"default\",
                        \"icon\"  : \"ic_launcher\"
                        \"color\" : \"$color\"
	                }
	            }";

        $context = stream_context_create(array(
            'http' => array(
                'method' => "POST",
                'header' => "Authorization: " . $server_key . "\r\n" .
                    "Content-Type: application/json\r\n",
                'content' => "$json"
            )
        ));

        $response = file_get_contents($api_url, FALSE, $context);

        if ($response === FALSE) {
            die('Error Alert');
        } else {
            echo $response;
        }
    }
}
