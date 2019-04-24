<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixApprovedrecordsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP  VIEW IF EXISTS approvedrecords");
        DB::statement("CREATE VIEW approvedrecords as SELECT distinct records.* from records inner join proofs on records.id=proofs.id where proofs.approved='1' and proofs.decided='1'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
