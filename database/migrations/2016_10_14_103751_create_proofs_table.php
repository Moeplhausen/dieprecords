<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProofsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proofs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proof_link',255);
            $table->integer('approver_id')->unsigned()->default(1);
            $table->boolean('approved')->default(false);
            $table->boolean('decided')->default(0);
            $table->timestamps();
        });

        Schema::table('proofs',function($table){
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proofs');
    }
}
