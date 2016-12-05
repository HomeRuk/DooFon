<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_Predict extends Model
{
    protected  $table = 'modelpredict';
    
    protected $fillable = [
        'name'
    ];
}
