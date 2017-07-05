<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\DeviceController;
use App\Weather;
use App\Device;
use App\Http\Requests\WeatherRequest;
use App\Model_Predict;
use File;

class WeatherController extends Controller
{
    public function show($SerialNumber = null)
    {
        $serialnumber = Weather::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('weather.get', [
            'serialnumbers' => $serialnumber
        ]); // Weather/get.blade.php
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\WeatherRequest $request
     * @return \Illuminate\Http\Response
     * URL Path : /Weather
     */
    public function store(WeatherRequest $request)
    {
        $SerialNumber = $request->SerialNumber;
        $device = Device::where('SerialNumber', '=', $SerialNumber)->first();

        // Save weather rain
        $Weather = new Weather();
        $Weather->temp = $request->temp;
        $Weather->humidity = $request->humidity;
        $Weather->dewpoint = $request->dewpoint;
        $Weather->pressure = $request->pressure;
        $Weather->light = $request->light;
        $Weather->rain = $request->rain;
        $Weather->devices_id = $device->id;
        $Weather->save();

        $devices_id = $Weather->devices_id;
        self::predict($devices_id, $SerialNumber);
    }

    public static function predict($devices_id, $SerialNumber)
    {
        $WeatherLast = Weather::where('devices_id','=',$devices_id)->get()->last();

        $arffWeatherLast = "@relation $SerialNumber\r\n"
            . "@attribute temp numeric\r\n"
            . "@attribute humidity numeric\r\n"
            . "@attribute dewpoint numeric\r\n"
            . "@attribute pressure numeric\r\n"
            . "@attribute light numeric\r\n"
            . "@attribute rain {0, 1}\r\n\r\n"
            . "@data\r\n"
            . $WeatherLast->temp . ','
            . $WeatherLast->humidity . ','
            . $WeatherLast->dewpoint . ','
            . $WeatherLast->pressure . ','
            . $WeatherLast->light . ','
            . $WeatherLast->rain;
        //Write or New file arffWeatherLast > arff
        $arffFile = public_path() . '/weka/arff/' . $SerialNumber . '.arff';
        $fp = fopen($arffFile, 'w') or die("Unable to open file!");
        fwrite($fp, $arffWeatherLast);
        fclose($fp);

        /*
            Check realFile arffFile
         */
        if (!File::exists($arffFile)) {
            abort(404);
        }

        /*
        * ****** RandomForest *******
        * ********** Weka ***********
        */

        //  2Hr
        $model = Model_Predict::all()->last();
        $modelname = $model->modelname;
        $modelFile = public_path() . '/weka/model/RandomForest/' . $modelname . '.model';
        /*
           Check realFile modelFile
        */
        if (empty($model->modelname) || !File::exists($modelFile)) {
            abort(404);
        }
        $RandomForest = 'java -cp '
            . public_path() . '/weka/weka.jar weka.classifiers.trees.RandomForest -T '
            . public_path() . '/weka/arff/' . $SerialNumber . '.arff -l '
            . public_path() . '/weka/model/RandomForest/' . $modelname . '.model -p 0 ';

        //Run command shell for model testing 1 last record weather
        exec($RandomForest, $execOutput);

        // Check exec
        if (sizeof($execOutput) === 0) {
            die('Error exec'); // exec error
        }
        // String array to string $outputs
        $outputs = '';
        for ($i = 0; $i < sizeof($execOutput); $i++) {
            $outputs = $outputs . trim($execOutput[$i]);
        }
        // Filter output prediction
        $outputRegex = preg_replace('/[^0-9.]/', '', $outputs);
        // Result Predicted 0 or 1
        $outputPredicted = substr($outputRegex, 4, 1);
        // Result Prediction 0.00 - 1
        $outputPrediction = substr($outputRegex, 5);

        // Check result prediction and Convert format to class1
        switch ($outputPredicted) {
            case '0':
                $outputPrediction = abs($outputPrediction - 1) * 100;
                break;
            case '1':
                $outputPrediction = $outputPrediction * 100;
                break;
            default:
                die("Error OutputPredicted");
        }

        // Notify to Device
        self::notifyPredict($devices_id, $SerialNumber, $outputPrediction);

        // Update PredictPercent to Database
        self::updatePredict($devices_id, $SerialNumber, $outputPrediction);

    }

    // Notification prediction rain
    public static function notifyPredict($devices_id, $SerialNumber, $outputPrediction)
    {
        $device = Device::where('SerialNumber', '=', $SerialNumber)->first();
        $FCMtoken = $device->FCMtoken;
        $FCMTokenweb = Device::find($devices_id)->user()->get()->last()->FCMTokenweb;

        // Compare PercentRainCurrent vs SettingThresholdDevice
        if ($outputPrediction >= $device->threshold) {
            DeviceController::alertToDevice($SerialNumber, $outputPrediction, $FCMtoken);
            UserController::alertToWeb($devices_id, $SerialNumber, $outputPrediction, $FCMTokenweb);
        }
    }

    // Update PredictPercent to Database
    public static function updatePredict($devices_id, $SerialNumber, $outputPrediction)
    {
        // Update PredictPercent
        $model = Model_Predict::all()->last();
        Weather::where('devices_id', '=', $devices_id)->get()->last()->update(
            [
                'PredictPercent' => $outputPrediction,
                'model_id' => $model->id
            ]
        );
        // Write Prediction output
        $fpw = fopen(public_path() . '/weka/output/' . $SerialNumber . '.txt', 'w') or die("Unable to open file!");
        fwrite($fpw, $outputPrediction);
        fclose($fpw);
    }
}
