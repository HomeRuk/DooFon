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
        'users_id',
    ];

    public function weather(){
        return $this->hasMany('App\Weather','devices_id','id');
    }

    /**
     * The device that belong to the user.
     */
    public function user()
    {
        return $this->belongsToMany('App\User', 'device_users', 'device_id', 'users_id')->withTimestamps();
    }
}
