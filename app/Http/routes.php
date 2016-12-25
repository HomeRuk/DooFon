<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Main
Route::get('/', 'HomeController@index');
// Authentication
Route::auth();
//API 
Route::get('/weather/{SerialNumber}','WeatherController@show');
Route::get('/device/{SerialNumber}','DeviceController@show');
Route::resource('/weather', 'WeatherController');
Route::resource('/device', 'DeviceController');
Route::get('/devices/insert','DeviceController@insert');
// Update Device
Route::post('/device/update/location','DeviceController@updateLocation');
Route::post('/device/update/threshold','DeviceController@updateThreshold');
Route::post('/device/update/FCMtoken','DeviceController@updateFCMtoken');
Route::post('/device/update/mode','DeviceController@updateMode');
// Chartreport Weather
Route::get('/weathers/overview','WeatherController@chartReport');
Route::resource('/model_predict', 'Model_PredictController');
// Download Training model & Data 
Route::get('/model_predict/download/arff/{model_predict}','Model_PredictController@downloadArff');
Route::get('/model_predict/download/model/{model_predict}','Model_PredictController@downloadModel');
// Download Report Training model
Route::get('/model_predict/download/txt/{model_predict}','Model_PredictController@downloadTXT');
Route::get('/model_predict/download/pdf/{model_predict}','Model_PredictController@downloadPDF');
Route::get('/model_predict/stream/pdf/{model_predict}','Model_PredictController@streamPDF');
// TEST Send Notio and Testing Model
Route::get('/send', function(){ return view('PHP_Sentform'); });
Route::get('/predict', function(){ return view('predict_model'); });