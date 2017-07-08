<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected  $table = 'profiles';
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
