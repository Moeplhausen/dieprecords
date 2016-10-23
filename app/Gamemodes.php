<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gamemodes extends Model
{
    public function records(){
        return   $this->hasMany('App\Records','gamemode_id','id');
    }
}
