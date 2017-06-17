<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected  $table = 'weather';
    protected  $fillable = [
        'temp',
        'humidity',
        'dewpoint',
        'pressure',
        'light',
        'rain',
        'SerialNumber',
        'PredictPercent',
        'model_id',
        'PredictMode'
    ];

    public function device() {
        return $this->belongsTo('App\Device', 'SerialNumber');
    }

    public function modelpredict() {
        return $this->belongsTo('App\Model_Predict', 'model_id');
    }

}