<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weathers';
    protected $fillable = [
        'temp',
        'humidity',
        'dewpoint',
        'pressure',
        'light',
        'rain',
        'PredictPercent',
        'TrainStatus',
        'devices_id',
        'model_id',
        'SerialNumber',
    ];

    public function device()
    {
        return $this->belongsTo('App\Device', 'id');
    }

    public function modelpredict()
    {
        return $this->belongsTo('App\Model_Predict', 'model_id');
    }

}