<?php

use Illuminate\Database\Seeder;

class RecordsTableSeeder extends Seeder
{

    private function submitRecord($name, $score, $proofurl, $gamemode_id, $tankid)
    {

        $response = $this->call('POST', '/submitrecord', array(
            '_token' => csrf_token(),
            'inputname' => $name,
            'score' => $score,
            'proof' => $proofurl,
            'gamemode_id' => $gamemode_id,
            'selectclass' => $tankid
        ));
        return $response;

    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
    }
}
