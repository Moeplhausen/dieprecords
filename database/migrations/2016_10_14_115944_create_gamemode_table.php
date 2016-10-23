<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamemodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamemodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',32);
            $table->timestamps();
            $table->engine = 'InnoDB';

        });

        Schema::table('gamemodes',function($table){
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gamemodes');
    }
}
