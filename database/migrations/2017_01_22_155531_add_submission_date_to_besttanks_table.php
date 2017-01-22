<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubmissionDateToBesttanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP  VIEW IF EXISTS besttanksview");

        DB::statement("CREATE VIEW besttanksview AS SELECT DISTINCT 
                sortedrecords.id AS record_id,
                sortedrecords.name AS name, 
                sortedrecords.score AS score, 
                sortedrecords.tank_id AS tank_id, 
                tanks.tankname AS tankname, 
                tanks.enabled AS tank_enabled,
                sortedrecords.gamemode_id AS gamemode_id, 
                gamemodes.name    AS gamemode, 
                gamemodes.mobile AS mobile,
                users.name AS approvername,
                proofs.id AS proof_id,
                proofs.submittedlink as submittedlink,
                proofs.updated_at AS approvedDate,
                proofs.created_at AS submittedDate,
                prooflinks.id AS prooflink_id,
                prooflinks.proof_link AS link
FROM   validrecordsview AS sortedrecords 
       INNER JOIN gamemodes 
               ON sortedrecords.gamemode_id = gamemodes.id 
       INNER JOIN tanks 
               ON sortedrecords.tank_id = tanks.id 
       INNER JOIN proofs 
               ON sortedrecords.id = proofs.id 
       INNER JOIN users
               ON proofs.approver_id = users.id
       INNER JOIN prooflinks
               ON proofs.id=prooflinks.proof_id
ORDER  BY tanks.tankname, 
          gamemode_id,
          prooflink_id");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP  VIEW IF EXISTS besttanksview");
    }
}
