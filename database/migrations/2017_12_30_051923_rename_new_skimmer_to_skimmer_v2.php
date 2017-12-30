<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNewSkimmerToSkimmerV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tanks')->where('tankname','New Skimmer')->update([
                'tankname' => 'Skimmer v2',
            ]
        );
        DB::table('tanks')->where('tankname','Skimmer')->update([
                'enabled' => 0,
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
        DB::table('tanks')->where('tankname','Skimmer v2')->update([
                'tankname' => 'New Skimmer',
            ]
        );
        DB::table('tanks')->where('tankname','Skimmer')->update([
                'enabled' => 1,
            ]
        );
    }
}
