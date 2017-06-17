<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
//Main
Route::get('/', 'HomeController@index');
// Authentication
Route::auth();
//API 
Route::get('/weather/{SerialNumber?}','WeatherController@show');
Route::get('/device/{SerialNumber?}','DeviceController@show');
Route::resource('/weathers', 'WeatherController');
Route::resource('/devices', 'DeviceController');

// Update Device
Route::post('/api/device/update/location','DeviceController@updateLocation');
Route::post('/api/device/update/threshold','DeviceController@updateThreshold');
Route::post('/api/device/update/FCMtoken','DeviceController@updateFCMtoken');
Route::post('/api/device/update/mode','DeviceController@updateMode');
// Chartreport Weather
Route::get('/report/weather/overview','WeatherController@chartReport');
Route::resource('/model_predict', 'Model_PredictController');
// Download Training model & Data 
Route::get('/model_predict/download/arff/{model_predict}','Model_PredictController@downloadArff');
Route::get('/model_predict/download/model/{model_predict}','Model_PredictController@downloadModel');
// Download Report Training model
Route::get('/model_predict/download/txt/{model_predict}','Model_PredictController@downloadTXT');
Route::get('/model_predict/download/pdf/{model_predict}','Model_PredictController@downloadPDF');
Route::get('/model_predict/stream/pdf/{model_predict}','Model_PredictController@streamPDF');
// TEST Send Notify and Testing Model
Route::get('/send', function(){ return view('PHP_Sentform'); });
Route::get('/predict', function(){ return view('predict_model'); });