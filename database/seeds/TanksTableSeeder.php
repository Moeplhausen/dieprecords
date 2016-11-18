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
            "Octo Tank",
            "Overlord",
            "Overseer",
            "Overtrapper",
            "Penta Shot",
            "Predator",
            "Quad Tank",
            "Ranger",
            "Smasher",
            "Sniper",
            "Spike",
            "Sprayer",
            "Spread Shot",
            "Stalker",
            "Streamliner",
            "Trapper",
            "Tri-Angle",
            "Tri-Trapper",
            "Triple Shot",
            "Triple Twin",
            "Triplet",
            "Twin",
            "Twin Flank");
        foreach ($tanks as $tank){
            DB::table('tanks')->insert(['tankname'=>$tank]);
        }

    }
}
