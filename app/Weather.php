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
        'SerialNumber'
    ];
}
