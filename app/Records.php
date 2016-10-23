<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    public function gamemode(){
      return  $this->belongsTo('App\Gamemodes','gamemode_id');
    }
    public function tank(){
        return  $this->belongsTo('App\Tanks','tank_id');
    }
    public function proof(){
        return  $this->hasOne('App\Proofs','id');
    }



}
