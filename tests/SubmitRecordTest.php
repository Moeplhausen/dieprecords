<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubmitRecordTest extends TestCase
{
    public function testSubmittingAValidRecord(){

    }
    public function testSubmittingAValidRecordWithExistingRecord(){

    }

    public function testSubmittingATooLowScore(){

    }

    public function testSubmittingAValidRecordTwice()
    {

    }

    public function testSubmittingSameScore(){
        //Submit a valid record

        //Deny it

        //Submit the same record again

        //approve it


        //Now test it without denying the first one

    }

    public function testSubmittingInvalidRecords(){

        //tankid does not exist

        //gamemodeid does not exist

        //score is too high

        //score is below 0

        //score is not a number

        //proof url is not valid

        //name was not put in

        //score was not put in

        //proof was not put in
    }
}
