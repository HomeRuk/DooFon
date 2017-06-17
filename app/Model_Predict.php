<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_Predict extends Model
{
    protected  $table = 'modelpredict';
    
    protected $fillable = [
        'modelname',
        'model',
        'exetime',
    ];
    
    public function weather() {
        return $this->hasMany('App\Weather');
    }
}
