<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected  $table = 'device';
    protected  $fillable = [
        'SerialNumber',
        'FCMtoken',
        'latitude',
        'longitude',
        'threshold',
    ];
}
