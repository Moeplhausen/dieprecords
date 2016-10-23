<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubmitRecordTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setup();
        $this->seed('TanksTableSeeder');
        $this->seed('GamemodesTableSeeder');
    }

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
        $this->assertEquals(302, $response->getStatusCode());
        return $response;

    }


    public function testSubmittingAValidRecord()
    {

        $gamemode = \App\Gamemodes::inRandomOrder()->first();
        $tank = \App\Tanks::inRandomOrder()->first();
        $name = "test1";
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";
        $score = 10;


        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id);

        $this->seeInDatabase('records', [
            'score' => $score,
            'tank_id' => $tank->id,
            'gamemode_id' => $gamemode->id,
            'name' => $name,
            'id' => 1
        ]);
        $this->seeInDatabase('proofs', [
            'approved' => false,
            'decided' => false,
            'id' => 1
        ]);

        $this->seeInDatabase('prooflinks', [
            'proof_id' => 1,
            'proof_link' => $proofurl,
            'id' => 1
        ]);

        $this->notSeeInDatabase('prooflinks', [
            'id' => 2
        ]);


    }

    public function testSubmittingAValidRecordWithExistingRecord()
    {

        $gamemode = \App\Gamemodes::inRandomOrder()->first();
        $tank = \App\Tanks::inRandomOrder()->first();
        $name = "test1";
        $name2="test2";
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";
        $score = 10;


        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id);
        $this->submitRecord($name2, $score+1, $proofurl, $gamemode->id, $tank->id);

        $this->seeInDatabase('records', [
            'score' => $score+1,
            'tank_id' => $tank->id,
            'gamemode_id' => $gamemode->id,
            'name' => $name2,
            'id' => 2
        ]);
    }

    public function testSubmittingATooLowScore()
    {
        $tank=factory(\App\Tanks::class)->create();
        $gamemode=factory(\App\Gamemodes::class)->create();
        $user=factory(\App\User::class)->create();
        $higherscore=100;
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";

        $recordproof1=$this->createRecord($user,$higherscore,$gamemode->id,$tank->id,"higherrecord");
        $name = "test1";
        $this->submitRecord($name, $higherscore-1, $proofurl, $gamemode->id, $tank->id);

        $this->seeInDatabase('records', [
            'score' => $higherscore,
            'tank_id' => $tank->id,
            'gamemode_id' => $gamemode->id,
        ]);

        $this->notSeeInDatabase('records', [
            'score' => $higherscore-1,
            'tank_id' => $tank->id,
            'gamemode_id' => $gamemode->id,
        ]);


    }

    public function testSubmittingAValidRecordTwice()
    {
        $gamemode = \App\Gamemodes::inRandomOrder()->first();
        $tank = \App\Tanks::inRandomOrder()->first();
        $name = "test1";
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";
        $score = 10;


        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id);
        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id);

        $this->notSeeInDatabase('records', [
            'id' =>2
        ]);

    }

    public function testSubmittingSameScore()
    {
        //Submit a valid record
        $gamemode = \App\Gamemodes::inRandomOrder()->first();
        $tank = \App\Tanks::inRandomOrder()->first();
        $name = "test1";
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";
        $score = 10;

        $this->notSeeInDatabase('proofs', [
            'decided' => false,
        ]);

        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id);

        //Deny it
        \App\Proofs::where('id',1)->update(['decided'=>true,'approved'=>false]);



        $this->notSeeInDatabase('proofs', [
            'decided' => false,
        ]);

        //Submit the same record again
        $this->submitRecord("test2", $score, $proofurl, $gamemode->id, $tank->id);


        //var_dump(\App\Records::all());

        $this->seeInDatabase('records', [
            'score' => $score,
            'tank_id' => $tank->id,
            'gamemode_id' => $gamemode->id,
            'id'=>2
        ]);



    }

    public function testSubmittingInvalidRecords()
    {
        $gamemode = \App\Gamemodes::inRandomOrder()->first();
        $tank = \App\Tanks::inRandomOrder()->first();
        $name = "test1";
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";
        $score = 10;


        //Submit a valid record
        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id);
        //tankid does not exist
        $this->submitRecord($name, $score, $proofurl, $gamemode->id, $tank->id*-1);
        //gamemodeid does not exist
        $this->submitRecord($name, $score, $proofurl, $gamemode->id*-1, $tank->id);
        //score is too high
        $this->submitRecord($name, $score*1000000000, $proofurl, $gamemode->id, $tank->id);
        //score is below 0
        $this->submitRecord($name, $score*-1, $proofurl, $gamemode->id, $tank->id);
        //score is not a number
        $this->submitRecord($name, "trololo", $proofurl, $gamemode->id, $tank->id);
        //proof url is not valid
        $this->submitRecord($name, $score, "http://google.com", $gamemode->id, $tank->id);
        $this->submitRecord($name, $score, "http://google.com/test.jpg", $gamemode->id, $tank->id);
        //name was not put in
        $this->submitRecord(null, $score, "http://google.com", $gamemode->id, $tank->id);
        //score was not put in
        $this->submitRecord($name, null, "http://google.com", $gamemode->id, $tank->id);
        //proof was not put in
        $this->submitRecord($name, $score, null, $gamemode->id, $tank->id);

        $this->seeInDatabase('records', [
            'score' => $score,
            'tank_id' => $tank->id,
            'gamemode_id' => $gamemode->id,
            'id'=>1
        ]);
        $this->notSeeInDatabase('records', [
            'id'=>2
        ]);




    }
}
