<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProoflinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prooflinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proof_id')->unsigned()->default(1);
            $table->string('proof_link',255);
            $table->timestamps();
            $table->engine = 'InnoDB';

        });
        Schema::table('prooflinks',function($table){
            $table->foreign('proof_id')->references('id')->on('proofs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prooflinks');
    }
}
