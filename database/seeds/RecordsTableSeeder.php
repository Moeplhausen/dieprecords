<?php

use Illuminate\Database\Seeder;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        DB::table('records')->insert(['name'=>'SortofShortShot','score'=>'1853290','tank_id'=>1,'gamemode_id'=>1,'ip_address'=>'127.0.0.1']);
        DB::table('proofs')->insert(['approver_id'=>1,'approved'=>true]);
        DB::table('prooflinks')->insert(['proof_id'=>'1', 'proof_link'=>'https://i.redd.it/hezmn5yo4ylx.png']);
    }
}
