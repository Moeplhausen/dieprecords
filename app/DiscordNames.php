<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscordNames extends Model
{
    protected $table = 'discord_names';


    public function name(){
        return  $this->hasOne('App\Names','id','nameId');
    }

}
