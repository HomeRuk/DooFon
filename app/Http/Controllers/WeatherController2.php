<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Requests\WeatherRequest;
// model 
use App\Weather;
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
        if ($rain == 1) {
            WeatherController::alert($SerialNumber);
        }
        //return redirect('sent');
        //$Weather->name = $request->name;
        //$Weather->save();
        //return redirect()->action('WeatherController@index');
    }

    public static function predict($SerialNumber) {
        $db_con = mysqli_connect('localhost', 'root', 'Ruk31332', 'webservice') or die('NO Connect to Database MySQL' . mysqli_connect_error());
        $sql = "SELECT temp, humidity, dewpoint, pressure, light, rain 
			FROM weather 
			WHERE SerialNumber = '$SerialNumber' 
			ORDER BY id DESC LIMIT 1;";
        $result = mysqli_query($db_con, $sql) or die('NO Connect to Database MySQL ' . mysqli_connect_error());
        $fp = fopen(public_path() . '/weka/arff/' . $SerialNumber . '.arff', 'w') or die("Unable to open file!");
        $arff = "@relation $SerialNumber\r\n@attribute temp numeric\r\n@attribute humidity numeric\r\n@attribute dewpoint numeric\r\n@attribute pressure numeric\r\n@attribute light numeric\r\n@attribute rain {0, 1}\r\n\r\n@data\r\n";

        fwrite($fp, $arff);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        // Close file 
        fclose($fp);
        
        // run command shell
        $shell = 'java -cp '
                . public_path() . '/weka/weka.jar weka.classifiers.lazy.IBk -T '
                . public_path() . '/weka/arff/' . $SerialNumber . '.arff -l '
                . public_path() . '/weka/model/IBk_0.model -p 0 > '
                . public_path() . '/weka/output/' . $SerialNumber . '.txt';
        exec($shell);
        dump($shell);
        $fpr = fopen(public_path() . '/weka/output/' . $SerialNumber . '.txt', 'r')or die("Unable to open file!");
        $fileread = fread($fpr, filesize(public_path() . '/weka/output/' . $SerialNumber . '.txt'));
        $outputRegex = preg_replace('/[^0-9.]/', '', $fileread);
        $output = substr($outputRegex, 5, 5);
        fclose($fpr);

        /*
        $sqlUpdate = "UPDATE weather
                        SET PredictPercent= $output, PredictStatus = '1'
                        WHERE SerialNumber = '$SerialNumber'
                        ORDER BY id DESC LIMIT 1;";
        mysqli_query($db_con, $sqlUpdate) or die('NO Connect to Database MySQL ' . mysqli_connect_error());
        */
        //Disconnect to database
        mysqli_close($db_con);
        
        $fpw = fopen(public_path() . '/weka/output/' . $SerialNumber . '.txt', 'w')or die("Unable to open file!");
        fwrite($fpw, $output);
        fclose($fpw);


        dump($output);
    }

    public static function alert($SerialNumber) {
        $FCMtokens = DB::select('SELECT FCMtoken FROM device WHERE SerialNumber = ? ', [$SerialNumber]);
        $api_url = "https://fcm.googleapis.com/fcm/send";
        $server_key = "key=AIzaSyD5QSI1ysohyLh8Yqv3Xcx6_SCsL8WJMLc";
        //$token_target ="fh8QgKbXe08:APA91bECkx2nhIaieh4aEzFsI9dQ_5v-OqzwPLUzTAoJihR1wJBatT2qOJEgh9q7ln3fJyZbpTndL3KPOmueWa621B0B_5aJCbq7_I5kU3HiT0TnrXwkAq8lMuTt6lLB5gdWu3mQ9a5O";
        foreach ($FCMtokens as $FCMtoken) {
            $token_target = $FCMtoken->FCMtoken;
        }
        $color = "#4FC3F7";
        $title = "DooFon";
        $body = $SerialNumber . " --> Rain!!!";

        $json = "{
	    \"to\" : \"$token_target\",
            \"collapse_key\" : \"DooFon\",    
	    \"priority\" : \"high\",
	    \"notification\" : {
	      \"body\"  : \"$body\",
	      \"title\" : \"$title\",
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
            die('Error');
        } else {
            echo $response;
        }
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
