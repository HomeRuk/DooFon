<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
