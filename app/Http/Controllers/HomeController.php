<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Weather;
use App\Device;
use App\Model_Predict;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
	$countW = Weather::count();
	$countD = Device::count();
        $countM = Model_Predict::count();
        return view('home',[
 	    'countW' => $countW,
            'countD' => $countD,
            'countM' => $countM
	]); //Home.blade.php
    }
   
}
