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

    public function weather(){
        return $this->hasMany('App\Weather', 'SerialNumber');
    }
}
