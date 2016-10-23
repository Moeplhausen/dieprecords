<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proofslink extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prooflinks';


    public function proof(){
        return $this->belongsTo('App\Proofs','id');
    }

}
