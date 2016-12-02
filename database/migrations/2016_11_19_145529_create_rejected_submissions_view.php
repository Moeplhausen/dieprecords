<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRejectedSubmissionsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP  VIEW IF EXISTS rejected_submissions_seven_days");
        DB::statement("CREATE VIEW rejected_submissions_seven_days AS SELECT DISTINCT records.id AS id, 
                records.name         AS name, 
                records.score        AS score, 
                tanks.tankname       AS tankname, 
                gamemodes.name       AS gamemode, 
                gamemodes.mobile     AS mobile, 
                proofs.submittedlink AS submittedlink,
                proofs.updated_at    AS proof_updated_at,
                users.name           AS manager, 
                records.created_at   AS submitted_at 
FROM   records 
       INNER JOIN proofs 
               ON records.id = proofs.id 
       INNER JOIN tanks 
               ON records.tank_id = tanks.id 
       INNER JOIN gamemodes 
               ON gamemodes.id = records.gamemode_id 
       INNER JOIN users 
               ON users.id = proofs.approver_id 
WHERE  proofs.approved = '0' 
       AND proofs.decided = '1' 
       AND proofs.updated_at >= ( Now() - INTERVAL 7 day ) 
ORDER  BY proofs.updated_at ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP  VIEW IF EXISTS rejected_submissions_seven_days");

    }
}
