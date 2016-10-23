<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';



    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();





        return $app;
    }


    public function createRecord($user,$score,$gamemode_id,$tank_id,$name,$approved=true,$decided=true){


        $recorddata=['score'=>$score,'gamemode_id'=>$gamemode_id,'tank_id'=>$tank_id,'name'=>$name];
        $record=factory(\App\Records::class)->create($recorddata);
        $record_id= $record->id;

        $user_id=$user->id;
        $proofdata=['id'=>$record_id,'approved'=>$approved,'decided'=>$decided,'approver_id'=>$user_id];
        $proof=factory(\App\Proofs::class)->create($proofdata);

        $proofid=$proof->id;
        $prooflink=factory(\App\Proofslink::class)->create(['proof_id'=>$proofid]);

        return ['record'=>$record,'proof'=>$proof,'prooflink'=>$prooflink];
    }



}
