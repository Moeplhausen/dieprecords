<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class SeeHomePageTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVisitAsBasicUser()
    {
        $this->visit('/')
            ->see('Diep.io World Records')
            ->see('Submit your record')
            ->see('Submitted Records',true)
            ->see('Logout',true);

    }

    public function testVisitAsAuthUser(){
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->visit('/')
            ->see('Diep.io World Records')
            ->see('Submit your record')
            ->see('Submitted Records',false)
            ->see('Logout',false);
    }
    public function testIfWeSeeEveryGamemode(){
        $this->seed('GamemodesTableSeeder');
        $gamemodes=\App\Gamemodes::all();
        foreach ($gamemodes as $gamemode){
            $this->visit('/')->see($gamemode->name);
        }
    }

    public function testSeeingTheHighestScoringTanks(){

        $tank=factory(\App\Tanks::class)->create(['tankname'=>"Basic Tank"]);
        $gamemode=factory(\App\Gamemodes::class)->create();
        $user=factory(\App\User::class)->create();

        $recordproof1=$this->createRecord($user,1,$gamemode->id,$tank->id,"one-tank");
        $recordproof2=$this->createRecord($user,2,$gamemode->id,$tank->id,"two-tank");



        $this->visit('/')
            ->see($recordproof2['record']->name)
            ->see($recordproof1['record']->name,true);


        $recordproof3=$this->createRecord($user,3,$gamemode->id,$tank->id,"three-tank");

        $this->visit('/')
            ->see($recordproof3['record']->name)
            ->see($recordproof2['record']->name,true)
            ->see($recordproof1['record']->name,true);

    }

    public function testOnlySeeTanksWithRecords(){
        $this->seed('TanksTableSeeder');
        $user=factory(\App\User::class)->create();
        $gamemode=factory(\App\Gamemodes::class)->create();

        $tanks=factory(\App\Tanks::class,5)->create();
        $onlytank=factory(\App\Tanks::class)->create();
        $this->createRecord($user,1,$gamemode->id,$onlytank->id,"only-tank-record");

        $tanks->each(function($t){
            $this->visit('/')
                ->see('scoretanksimage '.str_replace(" ","-",strtolower($t['tankname'])),true);
        });
        $this->visit('/')
            ->see('scoretanksimage '.str_replace(" ","-",strtolower($onlytank['tankname'])));

    }


}
