<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proofs extends Model
{


    public function links(){
        return $this->hasMany('App\Proofslink','proof_id','id');
    }
    public function user(){
        return   $this->belongsTo('App\User','approver_id');
    }
    public function record(){
        return   $this->belongsTo('App\Records','id');
    }

}
