<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Names extends Model
{
    public function records(){
        return $this->hasMany('App\Records','nameId','id');
    }
}
