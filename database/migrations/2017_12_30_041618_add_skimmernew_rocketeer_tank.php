<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkimmernewRocketeerTank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        DB::table('tanks')->insert([
                'tankname' => 'New Skimmer',
            ]
        );
        DB::table('tanks')->insert([
                'tankname' => 'Rocketeer',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tanks')->where('tankname','=','New Skimmer')->delete();
        DB::table('tanks')->where('tankname','=','Rocketeer')->delete();

    }
}
