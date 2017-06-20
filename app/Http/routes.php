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

// API Show Value
Route::get('/weather/{SerialNumber?}','Api\WeatherController@getWeather');
Route::get('/device/{SerialNumber?}','Api\DeviceController@getDevice');
// API Update Device
Route::post('/api/device/update/location','Api\DeviceController@updateLocation');
Route::post('/api/device/update/threshold','Api\DeviceController@updateThreshold');
Route::post('/api/device/update/FCMtoken','Api\DeviceController@updateFCMtoken');

// Web App
Route::resource('/devices', 'DeviceController');
Route::resource('/model_predicts', 'Model_PredictController');
Route::get('/map', 'MapController@index');
Route::get('/map/full', 'MapController@mapfull');
Route::get('/report','WeatherController@chartReport');


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
