<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUnnamedTankToSkimmer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        DB::table('tanks')->where('tankname','Unnamed Tank')->update(['tankname'=>'Skimmer']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tanks')->where('tankname','Skimmer')->update(['tankname'=>'Unnamed Tank']);
    }
}
