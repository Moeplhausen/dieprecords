<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord_names', function (Blueprint $table) {
            $table->increments('id');
            $table->char('discordId',64);
            $table->integer('nameId')->unsigned();
            $table->boolean('mayUpdate')->default(True);
            $table->timestamps();
            $table->engine = 'InnoDB';

        });


        Schema::table('discord_names',function($table){
            $table->unique('discordId');
            $table->unique('nameId');
            $table->foreign('nameId')->references('id')->on('names');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discord_names');
    }
}
