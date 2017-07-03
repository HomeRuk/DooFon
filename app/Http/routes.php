<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

//Main
Route::get('/', 'MainController@index');
// Authentication
Route::auth();
// Registration Routes...
Route::get('/admin/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/admin/register', 'Auth\RegisterController@register');

// API
Route::group(['middleware' => ['api']], function () {
// API Show Value
    Route::get('/api/weather/{SerialNumber?}', 'Api\WeatherController@getWeather');
    Route::get('/api/device/{SerialNumber?}', 'Api\DeviceController@getDevice');
// API POST Data from IoT Devices
    Route::post('/api/Weather', 'Api\WeatherController@store');
// API Update Device
    Route::post('/api/device/update/location', 'Api\DeviceController@updateLocation');
    Route::post('/api/device/update/threshold', 'Api\DeviceController@updateThreshold');
    Route::post('/api/device/update/FCMtoken', 'Api\DeviceController@updateFCMtoken');
});

// Web App for User
Route::group(['middleware' => ['admin']], function () {
    Route::resource('/admin/devices', 'Admin\DeviceController');
    Route::resource('/admin/model_predicts', 'Admin\Model_PredictController');
    Route::get('/admin/map', 'Admin\MapController@index');
    Route::get('/admin/map/full', 'Admin\MapController@mapFull');
    Route::get('/admin/report', 'Admin\WeatherController@chartReport');
// Download Training model & Data
    Route::get('/admin/model_predict/download/arff/{model_predict}', 'Admin\Model_PredictController@downloadArff');
    Route::get('/admin/model_predict/download/model/{model_predict}', 'Admin\Model_PredictController@downloadModel');
// Download Report Training model
    Route::get('/admin/model_predict/download/txt/{model_predict}', 'Admin\Model_PredictController@downloadTXT');
    Route::get('/admin/model_predict/download/pdf/{model_predict}', 'Admin\Model_PredictController@downloadPDF');
    Route::get('/admin/model_predict/stream/pdf/{model_predict}', 'Admin\Model_PredictController@streamPDF');
});

// Web App for User
Route::group(['middleware' => ['user']], function () {
    Route::resource('/user/devices', 'User\DeviceController');
    Route::get('/user/map', 'User\MapController@index');
    Route::get('/user/map/full', 'User\MapController@mapFull');
    Route::get('/user/report', 'User\WeatherController@chartReport');
});

Route::get('/user/user','User\UserController@index');
/*
// TEST Send Notify and Testing Model
Route::get('/send', function () {
    return view('PHP_Sentform');
});
Route::get('/predict', function () {
    return view('predict_model');
});
*/