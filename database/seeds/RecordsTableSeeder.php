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


        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/hezmn5yo4ylx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'SortofShortShot','score'=>'1850000','tank_id'=>1,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>1]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/235635224464195584/Screen_Shot_2016-10-12_at_1.29.45_AM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'vado','score'=>'1310000','tank_id'=>1,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>2]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/234755779901521921/Screenshot_301.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'357000','tank_id'=>2,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>3]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/mq2h9wyg58lx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'siriuslyron','score'=>'865000','tank_id'=>3,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>4]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/224235932822405121/230078418878726145/Screenshot_151.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'{O}Michael','score'=>'494000','tank_id'=>3,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>5]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/m6Aiak3.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Lelnoob','score'=>'1090000','tank_id'=>3,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>6]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/226705192974811136/Screenshot_2016-09-18_at_12.03.14_AM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'~O~GlitchPichu','score'=>'814000','tank_id'=>4,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>7]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/226594016089604098/Screenshot_2016-09-17_at_4.41.28_PM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'~O~GlitchPichu','score'=>'221000','tank_id'=>4,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>8]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/226293095187218442/Screenshot_2016-09-16_at_8.21.29_PM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'~O~GlitchPichu','score'=>'660000','tank_id'=>4,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>9]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/st7sujyrpijx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'[RDT]O.P.','score'=>'632000','tank_id'=>5,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>10]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/NToVTIm.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Panserbjorn3','score'=>'1040000','tank_id'=>5,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>11]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/219209584408002560/ice_screenshot_20160827-233439.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Cronut','score'=>'326000','tank_id'=>6,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>12]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/226997272632623104/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Platypuslover(Reserved)','score'=>'441000','tank_id'=>6,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>13]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/220043372897894400/T2.jpg','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'TESSERACT','score'=>'1010000','tank_id'=>7,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>14]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=c6vVwfBXfTg','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Anokuu','score'=>'1000000','tank_id'=>7,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>15]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/XydSPZe.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Androsynth','score'=>'834000','tank_id'=>8,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>16]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/8wBSani.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'addctn_','score'=>'1200000','tank_id'=>8,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>17]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/230978471076036608/Screenshot_195.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'JaeveX','score'=>'243000','tank_id'=>8,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>18]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/PHc3zTx.jpg','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'glowing_star','score'=>'1020000','tank_id'=>9,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>19]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/227263097155485697/Screen_Shot_2016-09-18_at_11.00.20_PM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'vado','score'=>'420000','tank_id'=>9,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>20]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/231961523478724610/2016-10-01_10_56_32-Greenshot.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'~O~ Sterlon','score'=>'240000','tank_id'=>9,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>21]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/UqfjeoK.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'an unnamed tank','score'=>'862000','tank_id'=>10,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>22]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/224282705737547777/booster_with_1.7mil.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Anonymous Beast','score'=>'1700000','tank_id'=>10,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>23]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/q8EYRRF.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'carbongroup','score'=>'384000','tank_id'=>10,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>24]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/219125765218893826/221104830582751244/1.2_mill_fighter_tdm.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Drag{O}nis','score'=>'1200000','tank_id'=>12,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>25]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/219851441181818882/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'{O}TIZZU','score'=>'1770000','tank_id'=>12,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>26]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/231819742615306241/Fighter_708k.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Platypuslover(Reserved)','score'=>'708000','tank_id'=>12,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>27]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=vBOSzNFaLNo','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'JustThatGood','score'=>'450000','tank_id'=>14,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>28]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/235873376407781376/Screenshot_313.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'218000','tank_id'=>14,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>29]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/231919261700849666/Screen_Shot_2016-10-01_at_4.22.09_PM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'fullmetal','score'=>'612000','tank_id'=>15,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>30]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/229244568770445313/WR_end.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'[RDT] O.P.','score'=>'960000','tank_id'=>15,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>31]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/236961064691040256/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'N{❂}ahTh3PandaTank','score'=>'408000','tank_id'=>16,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>32]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/227714920647622656/74.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'sunmoon','score'=>'391000','tank_id'=>16,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>33]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=WnDOQWecvO4','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Lagbreaker','score'=>'3080000','tank_id'=>17,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>34]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/219963161321668610/rec.jpg','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Relentless','score'=>'1070000','tank_id'=>18,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>35]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=hty7yS91K7M&feature=youtu.be','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Corrupt X','score'=>'942000','tank_id'=>18,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>36]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/ApaUWt8.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'xc0xupx','score'=>'702000','tank_id'=>18,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>37]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/229781731601940490/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'424000','tank_id'=>19,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>38]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=JjFKvB13xg4','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'{O} Chara','score'=>'1190000','tank_id'=>20,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>39]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/4yde54e7drnx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'An unnamed tank ','score'=>'2300000','tank_id'=>22,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>40]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/2NoIDCw.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'DDRMANIAC007','score'=>'1820000','tank_id'=>23,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>41]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/232337183263031296/234553747064356865/chrome_2016-10-09_00-52-33.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Cuvelia','score'=>'2110000','tank_id'=>23,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>42]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/mw3igitn11nx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'UltraXile','score'=>'2610000','tank_id'=>23,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>43]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/mqudtiln2bqx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'TM','score'=>'2870000','tank_id'=>24,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>44]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/228874529022148609/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'YOBA','score'=>'1360000','tank_id'=>24,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>45]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/231929434280689674/Screenshot_65.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'{O}FlyT','score'=>'1230000','tank_id'=>25,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>46]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/230348649371140096/Diep_World_Record.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Lytive','score'=>'289000','tank_id'=>25,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>47]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/225881180157771776/229051467858837504/wr_overtapper.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'~O~ Sterlon','score'=>'367000','tank_id'=>26,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>48]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/220043001332891648/A2.jpg','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Animal','score'=>'2140000','tank_id'=>27,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>49]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/231282455984734210/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Bela','score'=>'3290000','tank_id'=>27,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>50]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/228521587941310465/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Bela','score'=>'3520000','tank_id'=>27,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>51]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/uNvoXyT.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'xc0xupx','score'=>'492000','tank_id'=>27,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>52]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/ex8spp6aedfx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Maikri','score'=>'891000','tank_id'=>28,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>53]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/226816460977078272/WorldrecordPred2.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Platypuslover(Reserved)','score'=>'829000','tank_id'=>28,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>54]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/0f8tPlP.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Androsynth1000','score'=>'430000','tank_id'=>29,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>55]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/219893881817268225/quadtank2.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'TTTruck','score'=>'556000','tank_id'=>29,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>56]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/93wgqpuadprx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'pie314271','score'=>'218000','tank_id'=>29,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>57]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/227450203635056641/71.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'sunmoon','score'=>'609000','tank_id'=>30,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>58]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/236939806968512513/ranger_maze_record.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Solace','score'=>'346000','tank_id'=>30,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>59]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/236362880256049153/2016-10-13_22_40_23-Greenshot.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'~❂~ Sterlon','score'=>'573000','tank_id'=>31,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>60]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/230789915506376709/Sniper_3.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Platypuslover(Reserved)','score'=>'153000','tank_id'=>32,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>61]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=EtBRti6N0jk&feature=youtu.be','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Snapwing','score'=>'1140000','tank_id'=>33,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>62]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=lwkA-cgF9G0','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'N{O}ahTh3PandaTank','score'=>'1030000','tank_id'=>33,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>63]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/226384041207791617/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'vado','score'=>'1120000','tank_id'=>34,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>64]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/229281415924154368/Screen_Shot_2016-09-24_at_9.23.41_AM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'fullmetal','score'=>'414000','tank_id'=>34,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>65]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=Ftj080hZ7xU','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Chris Videos','score'=>'1800000','tank_id'=>35,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>66]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/aq8XCiz.jpg','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'glowing_star','score'=>'1790000','tank_id'=>35,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>67]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/a02jld4u0opx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Orgonecloud','score'=>'832000','tank_id'=>35,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>68]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/zly56n1580hx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'snoino','score'=>'417000','tank_id'=>37,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>69]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/214953543558234115/220043668877213696/Stream.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'YOBA','score'=>'509000','tank_id'=>37,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>70]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/8kca04j4crnx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'An unnamed tank','score'=>'596000','tank_id'=>37,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>71]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/220266426152386560/220266624974848001/Trapper_WR_.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Driftaca','score'=>'377000','tank_id'=>38,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>72]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/U0RXRjW.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Panserbjorn3','score'=>'155000','tank_id'=>38,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>73]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/6w6ltsfe3yqx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'1190000','tank_id'=>39,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>74]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/232996744114208768/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'1240000','tank_id'=>39,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>75]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/rxbuy6zzxipx.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'993000','tank_id'=>39,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>76]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/223092990544052224/tri_trapper_2.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'[RDT]O.P.','score'=>'501000','tank_id'=>40,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>77]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/8EHFmyD.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Drag{O}nis','score'=>'307000','tank_id'=>41,'gamemode_id'=>2,'ip_address'=>'127.0.0.1','proof_id'=>78]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/232337183263031296/234561213449764864/diep.io_WR.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'{O}','score'=>'212000','tank_id'=>41,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>79]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/232654459858190346/232654633825206272/Screen_Shot_2016-09-29_at_9.06.09_PM.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Drag{O}nis','score'=>'1950000','tank_id'=>42,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>80]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/229583239436697600/unknown.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'YOBA','score'=>'705000','tank_id'=>43,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>81]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.redd.it/zdaifh0lv1ox.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'An unnamed tank','score'=>'1200000','tank_id'=>44,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>82]);
        DB::table('proofs')->insert(['proof_link'=>'https://cdn.discordapp.com/attachments/222132681394225155/231557605040979968/Screenshot_288.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'☢','score'=>'465000','tank_id'=>44,'gamemode_id'=>4,'ip_address'=>'127.0.0.1','proof_id'=>83]);
        DB::table('proofs')->insert(['proof_link'=>'https://www.youtube.com/watch?v=mDra27m5raM','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Nema FirstPlace','score'=>'1500000','tank_id'=>45,'gamemode_id'=>1,'ip_address'=>'127.0.0.1','proof_id'=>84]);
        DB::table('proofs')->insert(['proof_link'=>'https://i.imgur.com/pM5AshP.png','approver_id'=>1,'approved'=>true]);
        DB::table('records')->insert(['name'=>'Elitar','score'=>'443000','tank_id'=>45,'gamemode_id'=>3,'ip_address'=>'127.0.0.1','proof_id'=>85]);
    }
}
