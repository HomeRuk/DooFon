<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Requests\WeatherRequest;
// model 
use App\Weather;
use App\Device;
use App\Model_Predict;
use DB;

class WeatherController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getWeather', 'store']]);
    }

    /**
     * Display a listing Weather and CountWeather
     * URL Path : /Weathers
     * Method : GET
     */
    public function index()
    {
        $Weather = Weather::paginate(100);
        return view('weather.index', [
            'Weathers' => $Weather,
        ]); //Weather/index.blade.php
    }

    /**
     * Store Weather
     * @param  \Illuminate\Http\WeatherRequest $request
     * URL Path : /weathers
     * Method : POST
     */
    public function store(WeatherRequest $request)
    {
        $Weather = new Weather();
        $Weather->create($request->all()); //$fillable
        WeatherController::predict($request->SerialNumber);
    }

    public function show($SerialNumber = null)
    {
        $serialnumber = Weather::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('weather.show', [
            'serialnumbers' => $serialnumber
        ]); // Weather/show.blade.php
    }

    public static function predict($SerialNumber)
    {
        $WeatherLast = Weather::all()->last();

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
        //Write file arffWeatherLast > arff
        $fp = fopen(public_path() . '/weka/arff/' . $SerialNumber . '.arff', 'w') or die("Unable to open file!");
        fwrite($fp, $arffWeatherLast);
        fclose($fp);

        /*
        * ****** RandomForest *******
        * ********** Weka ***********
        */

        //  2Hr
        $Model = Model_Predict::all()->last();
        $modelname = $Model->modelname;
        $RandomForest = 'java -cp '
            . public_path() . '/weka/weka.jar weka.classifiers.trees.RandomForest -T '
            . public_path() . '/weka/arff/' . $SerialNumber . '.arff -l '
            . public_path() . '/weka/model/RandomForest/' . $modelname . '.model -p 0 ';

        //Run command shell for testing 1 last record weather
        exec($RandomForest, $execOutput);

        // Check exec RandomTree
        if (sizeof($execOutput) == 0) {
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
        DeviceController::notifyPredict($SerialNumber, $outputPrediction);

        // Update PredictPercent to Database
        WeatherController::updatePredict($SerialNumber, $outputPrediction);

        /*  Debug
          // var_dump($execoutput);
          // dump($execOutput);
          // dump($outputs);
          // dump($outputRegex);
          // dump($outputPredicted);
          // dump($outputPrediction);
         */
    }

    // Update PredictPercent to Database
    public static function updatePredict($SerialNumber, $outputPrediction)
    {
        // Update PredictPercent
        $Model = Model_Predict::all()->last();
        Weather::where('SerialNumber', '=', $SerialNumber)->orderBy('id', 'desc')->first()->update(
            [
                'PredictPercent' => $outputPrediction,
                'model_id' => $Model->id
            ]
        );

        // Write Prediction output 
        $fpw = fopen(public_path() . '/weka/output/' . $SerialNumber . '.txt', 'w') or die("Unable to open file!");
        fwrite($fpw, $outputPrediction);
        fclose($fpw);
    }

    public function chartReport()
    {
        $countW = Weather::count();
        $tempWeather = DB::select('SELECT temp AS temperature, created_at AS timeweather FROM weather');
        $humidityWeather = DB::select('SELECT humidity, created_at AS timeweather FROM weather');
        $dewpointWeather = DB::select('SELECT dewpoint, created_at AS timeweather FROM weather');
        $pressureWeather = DB::select('SELECT pressure, created_at AS timeweather FROM weather');
        $lightWeather = DB::select('SELECT light, created_at AS timeweather FROM weather');
        $rainWeather = DB::select('SELECT rain, created_at AS timeweather FROM weather');
        return view('weather.overview', [
            'countW' => $countW,
            'tempWeathers' => $tempWeather,
            'humidityWeathers' => $humidityWeather,
            'dewpointWeathers' => $dewpointWeather,
            'pressureWeathers' => $pressureWeather,
            'lightWeathers' => $lightWeather,
            'rainWeathers' => $rainWeather,
        ]); //overview.blade.php
    }
}
