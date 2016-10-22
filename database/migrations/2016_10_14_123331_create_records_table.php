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
            $table->timestamps();
        });
        Schema::table('records',function($table){
            $table->foreign('tank_id')->references('id')->on('tanks')->onDelete('cascade');
            $table->foreign('gamemode_id')->references('id')->on('gamemodes')->onDelete('cascade');
            //$table->unique(array('score','tank_id','gamemode_id')); //prevents a valid submission when an invalid submission has the same score, tank, gamemode
         });
        Schema::table('proofs',function($table){
            $table->foreign('id')->references('id')->on('records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('records');
        Schema::enableForeignKeyConstraints();

    }
}
