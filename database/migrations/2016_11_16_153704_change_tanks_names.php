<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTanksNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('tanks')->where('tankname','Pentashot')->update([
                'tankname' => 'Penta Shot',
            ]
        );
        DB::table('tanks')->where('tankname','Spreadshot')->update([
                'tankname' => 'Spread Shot',
            ]
        );
        DB::table('tanks')->where('tankname','Octotank')->update([
                'tankname' => 'Octo Tank',
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
        DB::table('tanks')->where('tankname','Penta shot')->update([
                'tankname' => 'Pentashot',
            ]
        );

        DB::table('tanks')->where('tankname','Spread Shot')->update([
                'tankname' => 'Spreadshot',
            ]
        );
        DB::table('tanks')->where('tankname','Octo Tank')->update([
                'tankname' => 'Octotank',
            ]
        );
    }
}
