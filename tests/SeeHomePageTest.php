<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeeHomePageTest extends TestCase
{
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

    public function testSeeingTheHighestScoringTanks(){

    }

    public function testOnlySeeTanksWithRecords(){

    }

    public function testSeeAllGamemodes()
    {

    }


}
