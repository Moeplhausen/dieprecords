<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('score',false,true);
            $table->integer('tank_id')->unsigned();
            $table->integer('gamemode_id')->unsigned();
            $table->string('ip_address',45);
            $table->integer('proof_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('records',function($table){
            $table->foreign('tank_id')->references('id')->on('tanks');
            $table->foreign('gamemode_id')->references('id')->on('gamemodes');
            $table->unique('proof_id');
            $table->foreign('proof_id')->references('id')->on('proofs');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
