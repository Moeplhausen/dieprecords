<?php

use Illuminate\Database\Seeder;

class RecordsTableSeeder extends Seeder
{

    private function submitRecord($name, $score, $proofurls, $gamemode_id, $tankid)
    {
        static $counter = 0;
        $counter++;


        DB::table('records')->insert(['name' => $name, 'score' => $score, 'tank_id' => $tankid, 'gamemode_id' => $gamemode_id, 'ip_address' => '127.0.0.1','created_at'=>new DateTime()]);
        DB::table('proofs')->insert(['approver_id' => 1, 'approved' => true,'submittedlink' => $proofurls[0],'created_at'=>new DateTime() ]);

        for ($i=0;$i<count($proofurls);$i++)
             DB::table('prooflinks')->insert(['proof_id' => $counter, 'proof_link' => $proofurls[$i],'created_at'=>new DateTime()]);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $this->submitRecord("Sortof",100,array("https://i.redd.it/hezmn5yo4ylx.png"),3,1);
        $this->submitRecord("derp",100,array("https://i.imgur.com/zmEu90q.png","https://i.imgur.com/Qa48OQY.png","https://i.imgur.com/LMkNEWj.png"),3,2);
        $this->submitRecord("test",100,array("http://imgur.com/EwmGtqV"),3,3);

        http://imgur.com/EwmGtqV
    }
}
