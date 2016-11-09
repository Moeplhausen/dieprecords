<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobilecolumnToGamemodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamemodes', function (Blueprint $table) {
            $table->boolean('mobile')->default(false)->after('name');
            $table->dropUnique('gamemodes_name_unique');
            });
        Schema::table('gamemodes', function (Blueprint $table) {
            $table->unique(['name','mobile']);
        });

        DB::table('gamemodes')->insert([            [
                'name' => 'FFA',
                'mobile'=>true,
            ],[
                'name' => '2-TDM',
                'mobile' => true,
            ],
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

        DB::table('gamemodes')->where(['name'=>'FFA','mobile'=>true])->delete();
        DB::table('gamemodes')->where(['name'=>'2-TDM','mobile'=>true])->delete();

        Schema::table('gamemodes', function (Blueprint $table) {
            $table->dropColumn('mobile');
            $table->unique('name');
        });


    }
}
