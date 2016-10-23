<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanks extends Model
{
    public function records(){
        return  $this->hasMany('App\Records','tank_id');
    }
}
