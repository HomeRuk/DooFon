<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Requests\WeatherRequest;
// model 
use App\Weather;
use App\Device;
use DB;

class WeatherController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => ['show', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //$Weather = Weather::all()->last();
        //$Weather  = Weather::where('pressure', '=', 1001.50)->get()->last();
        //$Weather = DB::select('SELECT temp, humidity, dewpoint, pressure, light, rain FROM weather WHERE SerialNumber = ? ORDER BY id DESC LIMIT 1', ['ZgkL2LfL0Q']);
        $Weather = Weather::paginate(100);
        $count = Weather::count();
        return view('weather.index', [
            'Weathers' => $Weather,
            'count' => $count,
        ]); //Weather/index.blade.php
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\WeatherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WeatherRequest $request) {
        $Weather = new Weather();
        $Weather->create($request->all()); //$fillable
        $rain = $request->rain;
        $SerialNumber = $request->SerialNumber;
        WeatherController::predict($SerialNumber);

        //return redirect('sent');
        //$Weather->name = $request->name;
        //$Weather->save();
        //return redirect()->action('WeatherController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function show($SerialNumber) {
        $serialnumber = Weather::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('weather.show', [
            'serialnumbers' => $serialnumber
        ]); // Weather/show.blade.php
    }

    public static function predict($SerialNumber) {
        //Connect
        $db_con = mysqli_connect('localhost', 'root', 'Ruk31332', 'webservice') or die('NO Connect to Database MySQL' . mysqli_connect_error());
        $sql = "SELECT temp, humidity, dewpoint, pressure, light, rain 
			FROM weather 
			WHERE SerialNumber = '$SerialNumber' 
			ORDER BY id DESC LIMIT 1;";
        //Query Select weather for predict
        $result = mysqli_query($db_con, $sql) or die('NO Connect to Database MySQL ' . mysqli_connect_error());

        //Write file arff
        $fp = fopen(public_path() . '/weka/arff/' . $SerialNumber . '.arff', 'w') or die("Unable to open file!");
        $arff = "@relation $SerialNumber\r\n"
                . "@attribute temp numeric\r\n"
                . "@attribute humidity numeric\r\n"
                . "@attribute dewpoint numeric\r\n"
                . "@attribute pressure numeric\r\n"
                . "@attribute light numeric\r\n"
                . "@attribute rain {0, 1}\r\n\r\n"
                . "@data\r\n";
        fwrite($fp, $arff);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        /*
          // RandomTree
          // Run command shell for testing 1 last record weather
          $RandomTree = 'java -cp '
          . public_path() . '/weka/weka.jar weka.classifiers.trees.RandomTree -T '
          . public_path() . '/weka/arff/' . $SerialNumber . '.arff -l '
          . public_path() . '/weka/model/RandomTree/RandomTree.model -p 0';
          exec($RandomTree, $execOutput1);
          // Check exec RandomTree
          if (sizeof($execOutput1) == 0) {
          die("0"); // exec error
          }
          // String array to string $outputs
          $outputs1 = '';
          for ($i = 0; $i < sizeof($execOutput1); $i++) {
          $outputs1 = $outputs1 . trim($execOutput1[$i]);
          }
          // Filter output prediction
          $outputRegex1 = preg_replace('/[^0-9.]/', '', $outputs1);
          $outputPredicted1 = substr($outputRegex1, 4, 1);
          $outputPrediction1 = substr($outputRegex1, 5);
          switch ($outputPredicted1) {
          case '0':
          $outputPrediction1 = abs($outputPrediction1 - 1) * 100;
          break;
          case '1':
          $outputPrediction1 = $outputPrediction1 * 100;
          break;
          default:
          echo "Error";
          }

          // MultilayerPerceptron
          // Run command shell for testing 1 last record weather
          $MultilayerPerceptron = 'java -cp '
          . public_path() . '/weka/weka.jar weka.classifiers.functions.MultilayerPerceptron -T '
          . public_path() . '/weka/arff/' . $SerialNumber . '.arff -l '
          . public_path() . '/weka/model/MultilayerPerceptron/MultilayerPerceptron_1.model -p 0';
          exec($MultilayerPerceptron, $execOutput2);
          // Check exec RandomTree
          if (sizeof($execOutput2) == 0) {
          die("0"); // exec error
          }
          // String array to string $outputs
          $outputs2 = '';
          for ($i = 0; $i < sizeof($execOutput2); $i++) {
          $outputs2 = $outputs2 . trim($execOutput2[$i]);
          }
          // Filter output prediction
          $outputRegex2 = preg_replace('/[^0-9.]/', '', $outputs2);
          $outputPredicted2 = substr($outputRegex2, 4, 1);
          $outputPrediction2 = substr($outputRegex2, 5);
          switch ($outputPredicted2) {
          case '0':
          $outputPrediction2 = abs($outputPrediction2 - 1) * 100;
          break;
          case '1':
          $outputPrediction2 = $outputPrediction2 * 100;
          break;
          default:
          echo "Error2";
          }
         */
        // AVG outputPredictio
        //$outputPrediction = ($outputPrediction1 + $outputPrediction2) / 2;
        // RandomForest
        // Run command shell for testing 1 last record weather  
        $RandomForest = 'java -cp '
                . public_path() . '/weka/weka.jar weka.classifiers.trees.RandomForest -T '
                . public_path() . '/weka/arff/' . $SerialNumber . '.arff -l '
                . public_path() . '/weka/model/RandomForest/RandomForest.model -p 0';
        exec($RandomForest, $execOutput0);
        // Check exec RandomTree
        if (sizeof($execOutput0) == 0) {
            die("0"); // exec error
        }
        // String array to string $outputs
        $outputs0 = '';
        for ($i = 0; $i < sizeof($execOutput0); $i++) {
            $outputs0 = $outputs0 . trim($execOutput0[$i]);
        }
        // Filter output prediction 
        $outputRegex0 = preg_replace('/[^0-9.]/', '', $outputs0);
        $outputPredicted0 = substr($outputRegex0, 4, 1);
        $outputPrediction0 = substr($outputRegex0, 5);
        switch ($outputPredicted0) {
            case '0':
                $outputPrediction0 = abs($outputPrediction0 - 1) * 100;
                break;
            case '1':
                $outputPrediction0 = $outputPrediction0 * 100;
                break;
            default:
                die("Error");
        }
        $outputPrediction = $outputPrediction0 + 100;
        // Notification to Device
        DeviceController::notificationPredict($SerialNumber, $outputPrediction);

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
    public static function updatePredict($SerialNumber, $outputPrediction) {
        // Update PredictPercent
        $device = Weather::where('SerialNumber', '=', $SerialNumber)->orderBy('id', 'desc')->first()
                ->update([
            'PredictPercent' => $outputPrediction,
        ]);
        // Write Prediction output 
        $fpw = fopen(public_path() . '/weka/output/' . $SerialNumber . '.txt', 'w')or die("Unable to open file!");
        fwrite($fpw, $outputPrediction);
        fclose($fpw);
    }

    public function chartReport() {
        $countW = Weather::count();
        $countD = Device::count();
        $tempWeather = DB::select('SELECT temp AS temperature, created_at AS timeweather FROM weather');
        $humidityWeather = DB::select('SELECT humidity, created_at AS timeweather FROM weather');
        $dewpointWeather = DB::select('SELECT dewpoint, created_at AS timeweather FROM weather');
        $pressureWeather = DB::select('SELECT pressure, created_at AS timeweather FROM weather');
        $lightWeather = DB::select('SELECT light, created_at AS timeweather FROM weather');
        $rainWeather = DB::select('SELECT rain, created_at AS timeweather FROM weather');
        return view('weather.overview', [
            'countW' => $countW,
            'countD' => $countD,
            'tempWeathers' => $tempWeather,
            'humidityWeathers' => $humidityWeather,
            'dewpointWeathers' => $dewpointWeather,
            'pressureWeathers' => $pressureWeather,
            'lightWeathers' => $lightWeather,
            'rainWeathers' => $rainWeather,
        ]); //overview.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

      public function edit($id)
      {
      //
      }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response

      public function update(Request $request, $id)
      {
      //
      }
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

      public function destroy($id)
      {
      //
      }
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response

      public function create()
      {
      //
      }
     */
}
