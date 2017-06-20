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
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register');

// Web App
Route::resource('/weathers', 'WeatherController');
Route::resource('/devices', 'DeviceController');
Route::resource('/model_predicts', 'Model_PredictController');
// API Show Value
Route::get('/weather/{SerialNumber?}','WeatherController@getWeather');
Route::get('/device/{SerialNumber?}','DeviceController@getDevice');
// API Update Device
Route::post('/api/device/update/location','DeviceController@updateLocation');
Route::post('/api/device/update/threshold','DeviceController@updateThreshold');
Route::post('/api/device/update/FCMtoken','DeviceController@updateFCMtoken');
//Route::post('/api/device/update/mode','DeviceController@updateMode');
Route::get('/map', 'MapController@index');
// ChartReport Weather
Route::get('/report/weather/overview','WeatherController@chartReport');

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
