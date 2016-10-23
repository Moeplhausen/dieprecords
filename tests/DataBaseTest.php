<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DataBaseTest extends TestCase
{
    use DatabaseMigrations;

    private $defaulttank=null;
    private $defaultgamemode=null;
    private $defaultuser=null;
    private $defaultRecord=null;
    private $defaultProof=null;


    private function setupTestData()
    {

        $this->seed('UsersTableSeeder');
        $this->defaulttank=factory(\App\Tanks::class)->create(['tankname'=>"Basic Tank"]);
        $this->defaultgamemode=factory(\App\Gamemodes::class)->create();
        $this->defaultuser=factory(\App\User::class)->create();

        $recordAndProof=$this->createRecord($this->defaultuser,1,$this->defaultgamemode->id,$this->defaulttank->id,"DefaultRecord");


        $this->defaultRecord=$recordAndProof['record'];
        $this->defaultProof=$recordAndProof['proof'];


    }


    public function testHasDisabledAdminUserInDataBase(){
        $this->seed('UsersTableSeeder');
        $this->seeInDatabase('users', [
            'id' => 1,
            'enabled'=>false
        ]);
    }
/*
//Tests don't work with Sqlite. Probably the foreign key not enabled issue
    public function testRemovingAGamemodeAndCheckRecords(){
        $this->setupTestData();

        $this->seeInDatabase('records',['id'=>$this->defaultRecord->id,]);

        \App\Gamemodes::destroy($this->defaultgamemode->id);

        $this->dontSeeInDatabase('records',[
           'id'=>$this->defaultRecord->id,
        ]);


    }

    public function testRemovingAGamemodeAndCheckProofs(){
        $this->setupTestData();

        $this->seeInDatabase('proofs',['id'=>$this->defaultProof->id,]);
        \App\Gamemodes::destroy($this->defaultgamemode->id);

        $this->dontSeeInDatabase('proofs',[
            'id'=>$this->defaultProof->id,
        ]);

    }

    public function testRemovingARecordAndCheckProofs(){
        $this->setupTestData();

        $this->seeInDatabase('proofs',['id'=>$this->defaultProof->id,]);

        \App\Records::destroy($this->defaultRecord->id);
        $this->dontSeeInDatabase('proofs',[
            'id'=>$this->defaultProof->id,
        ]);


    }

*/

}
