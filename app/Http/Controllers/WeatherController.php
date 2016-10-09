<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Requests\WeatherRequest;
// model 
use App\Weather;

class WeatherController extends Controller
{
    public function __construct() {
        $this->middleware('auth',['except' => ['show','store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$Weather = Weather::all()-> last();
	//$device = Weather::where('pressure', '=', 1001.50)->get()->last();
	$Weather = Weather::paginate(100);
        $count = Weather::count();
        return view('weather.index',[
            'Weathers' => $Weather,
	    'count' => $count,
        ]); //Weather/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     
    public function create()
    {
        //
    }
    */
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\WeatherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WeatherRequest $request)
    {
        $Weather = new Weather();
        //$Weather->name = $request->name;
        //$Weather->save();
        $Weather->create($request->all()); //$fillable
        //return redirect()->action('WeatherController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $SerialNumber
     * @return \Illuminate\Http\Response
     */
    public function show($SerialNumber)
    {
        $serialnumber = Weather::where('SerialNumber', '=', $SerialNumber)->get()->last();
        return view('weather.show',[
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
}
