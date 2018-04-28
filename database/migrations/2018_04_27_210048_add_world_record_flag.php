<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorldRecordFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->integer('world_record')->default(1)->after('name');
        });

        DB::statement("DROP  VIEW IF EXISTS besttanksview");
        DB::statement("DROP  VIEW IF EXISTS validrecordsview");
        DB::statement("DROP  VIEW IF EXISTS validrecordsviewbasicmax");
        DB::statement("DROP  VIEW IF EXISTS approvedrecords");


        DB::statement("CREATE VIEW approvedrecords as SELECT distinct records.* from records inner join proofs on records.id=proofs.id where proofs.approved='1'");
        DB::statement("CREATE VIEW validrecordsviewbasicmax AS SELECT DISTINCT gamemode_id, 
                                  tank_id, 
                                  Max(score) AS score 
                           FROM   records 
                                  INNER JOIN proofs 
                                          ON records.id = proofs.id 
                           WHERE  proofs.approved = '1' 
                           GROUP  BY tank_id, 
                                     gamemode_id, 
                                     world_record");
        DB::statement("CREATE VIEW validrecordsview AS select record.* from approvedrecords record 
               INNER JOIN validrecordsviewbasicmax grouprecord 
                       ON record.gamemode_id = grouprecord.gamemode_id 
                          AND record.tank_id = grouprecord.tank_id 
                          AND record.score = grouprecord.score");


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
                sortedrecords.world_record AS world_record,
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
        DB::statement("DROP  VIEW IF EXISTS validrecordsview");
        DB::statement("DROP  VIEW IF EXISTS validrecordsviewbasicmax");
        DB::statement("DROP  VIEW IF EXISTS approvedrecords");


        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('world_record');
        });
    }
}
