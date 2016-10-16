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

        $counter=1;

        $tanksnumber=DB::select('select count(id) as max from tanks')[0]->max;
        $gamemodesnumber=DB::select('select count(id) as max from gamemodes')[0]->max;
        for ($i=1;$i<=$gamemodesnumber;$i++){
            for ($j=1;$j<=$tanksnumber;$j++){
               // DB::table('proofs')->insert(['proof_link'=>"https://i.imgur.com/cADzYab.jpg",'approver_id'=>1,'approved'=>true]);
                //DB::table('records')->insert(['name'=>"MasterOv",'score'=>"40000",'tank_id'=>$j,'gamemode_id'=>$i,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);
            }
        }



        //8 extra insertions
        DB::table('proofs')->insert(['proof_link'=>"https://i.redd.it/hezmn5yo4ylx.png",'approver_id'=>1,'approved'=>false]);
        DB::table('records')->insert(['name'=>"SortofShortShot",'score'=>"1853290",'tank_id'=>1,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"https://i.redd.it/hezmn5yo4ylx.png",'approver_id'=>1,'approved'=>true,'decided'=>true]);
        DB::table('records')->insert(['name'=>"SortofShortShotSmaller",'score'=>"1753290",'tank_id'=>1,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"http://i.imgur.com/UoMNPxn.png",'approver_id'=>1,'approved'=>false]);
        DB::table('records')->insert(['name'=>"Demic",'score'=>"401344",'tank_id'=>2,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"http://i.imgur.com/UoMNPxn.png",'approver_id'=>1,'approved'=>true,'decided'=>true]);
        DB::table('records')->insert(['name'=>"DemicSmaller",'score'=>"400000",'tank_id'=>2,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"http://s9.postimg.org/glkmbc51r/record.png",'approver_id'=>1,'approved'=>true,'decided'=>true]);
        DB::table('records')->insert(['name'=>"sholomar",'score'=>"629560",'tank_id'=>1,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"https://cdn.discordapp.com/attachments/222132681394225155/235635224464195584/Screen_Shot_2016-10-12_at_1.29.45_AM.png",'approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>"vado",'score'=>"1305511",'tank_id'=>1,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"https://i.imgur.com/B5JPYZZ.png",'approver_id'=>1,'approved'=>false]);
        DB::table('records')->insert(['name'=>"shawnster480",'score'=>"649734",'tank_id'=>1,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);

        DB::table('proofs')->insert(['proof_link'=>"https://www.youtube.com/watch?v=vBOSzNFaLNo",'approver_id'=>1,'approved'=>true,'decided'=>true]);
        DB::table('records')->insert(['name'=>"JustThatGood",'score'=>"450000",'tank_id'=>14,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>$counter++]);






    }
}
