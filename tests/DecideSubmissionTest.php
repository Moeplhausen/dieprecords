<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DecideSubmissionTest extends TestCase
{

    use DatabaseMigrations;

    protected $defaultuser='';
    protected $defaultproof='';
    protected $defaultscore=0;

    protected function setUp()
    {
        parent::setup();
        $this->seed('TanksTableSeeder');
        $this->seed('GamemodesTableSeeder');


        $gamemode = \App\Gamemodes::inRandomOrder()->first();
        $tank = \App\Tanks::inRandomOrder()->first();
        $this->defaultuser=$user = factory(\App\User::class)->create();
        $name = "test1";
        $proofurl = "https://i.redd.it/hezmn5yo4ylx.png";
        $this->defaultscore=$score = 10;

        $data=$this->createRecord($user, $score, $gamemode->id, $tank->id, $name, false, false);
        $this->defaultproof=$data['proof'];
    }

    private function submitDecision($answ, $id, $score)
    {

        $response = $this->actingAs($this->defaultuser)->call('POST', '/decidesubmission', array(
            '_token' => csrf_token(),
            'answ' => $answ,
            'score' => $score,
            'id' => $id,
        ));
        $this->assertEquals(200, $response->getStatusCode());
        return $response;

    }



    public function testApprovingAValidSubmission()
    {
        $this->seeInDatabase('proofs', [
            'id'=>$this->defaultproof->id,
            'approved'=>false,
            'decided'=>false,
        ]);
        $this->seeInDatabase('records', [
            'score'=>$this->defaultscore,
            'id'=>$this->defaultproof->id
        ]);

        $this->submitDecision(true,$this->defaultproof->id,1000);


        $this->seeInDatabase('proofs', [
            'approved'=>true,
            'decided'=>true,
            'id'=>$this->defaultproof->id
        ]);
        $this->seeInDatabase('records', [
            'score'=>1000,
            'id'=>$this->defaultproof->id
        ]);


    }

    public function testApprovingAnInvalidSubmission()
    {
        $this->submitDecision(true,$this->defaultproof->id*-1,1000);
        $this->notSeeInDatabase('proofs', [
            'decided'=>true,
        ]);



    }

    public function testDenyingAValidSubmission()
    {
        $this->submitDecision(false,$this->defaultproof->id,1000);
        $this->seeInDatabase('proofs', [
            'approved'=>false,
            'decided'=>true,
            'id'=>$this->defaultproof->id
        ]);
        $this->seeInDatabase('records', [
            'score'=>1000,
            'id'=>$this->defaultproof->id
        ]);

    }

    public function testDenyingAnInvalidSubmission()
    {
        $this->submitDecision(false,$this->defaultproof->id*-1,1000);
        $this->seeInDatabase('proofs', [
            'approved'=>false,
            'decided'=>false,
        ]);
        $this->notSeeInDatabase('records', [
            'score'=>1000,
        ]);

    }

}
