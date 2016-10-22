<?php

use Illuminate\Database\Seeder;

class TanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tanks=array(
            "Annihilator",
            "Assassin",
            "Auto Gunner",
            "Auto Smasher",
            "Auto Trapper",
            "Auto 3",
            "Auto 5",
            "Basic Tank",
            "Battleship",
            "Booster",
            "Destroyer",
            "Fighter",
            "Flank Guard",
            "Gunner",
            "Gunner Trapper",
            "Hunter",
            "Hybrid",
            "Landmine",
            "Machine Gun",
            "Manager",
            "Mega Trapper",
            "Necromancer",
            "Octotank",
            "Overlord",
            "Overseer",
            "Overtrapper",
            "Pentashot",
            "Predator",
            "Quad Tank",
            "Ranger",
            "Smasher",
            "Sniper",
            "Spike",
            "Sprayer",
            "Spreadshot",
            "Stalker",
            "Streamliner",
            "Trapper",
            "Tri-Angle",
            "Triple Shot",
            "Triplet",
            "Triple Twin",
            "Tri-Trapper",
            "Twin",
            "Twin Flank");
        foreach ($tanks as $tank){
            DB::table('tanks')->insert(['tankname'=>$tank]);
        }

    }
}
