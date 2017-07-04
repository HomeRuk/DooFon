<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceLocationRequest;
use App\Http\Requests\DeviceThresholdRequest;
use App\Http\Requests\DeviceFCMtokenRequest;
use App\Device;

class DeviceController extends Controller
{
    public function getDevice($id = null)
    {
        $device = Device::findOrFail($id)->last();
        return view('device.get', [
            'device' => $device
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


    // Alert to device
    public static function alertToDevice($SerialNumber, $PredictPercent, $FCMtoken)
    {
        $token_target = $FCMtoken;
        $api_url = "https://fcm.googleapis.com/fcm/send";
        $server_key = "key=AIzaSyD5QSI1ysohyLh8Yqv3Xcx6_SCsL8WJMLc";
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
            die ('Error Alert of Device');
        } else {
            echo $response;
        }
    }
}
