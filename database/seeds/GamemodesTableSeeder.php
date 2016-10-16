<?php

use Illuminate\Database\Seeder;

class GamemodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gamemodes=array(
            "FFA",
            "2-TDM",
            "4-TDM",
            "Maze");
        foreach ($gamemodes as $gamemode){
            DB::table('gamemodes')->insert(['name'=>$gamemode]);
        }
    }
}
