<pre>
This thread is the official unofficial **World Record** archive.
&nbsp;
__________________________________________________________________________________________
*A message from previous owner*: I have decided to step down and hand over the WRA to TacoYoutube, due to being busy and not being able to keep the post up to date. It was a good 2 months, and I hope to see many more great players continue to break amazing records! Thank you all - _jamescb_
&nbsp;

(9/14/16): The excel file will no longer be updated.

ATTENTION (9/8/16):**LOWEST SCORE MUST BE AT LEAST 40K.**
&nbsp;

IMPORTANT UPDATE (8/25/16): From now on, players using **Auto 5, Auto 3, Gunner, Triple Shot and all classes of the trapper branch including Auto Trapper, will be required to submit their FIRST screenshot of their SPECIFIC class at 25k-45k**, and a SECOND screenshot of the deathscreen. Failure to provide both screenshots will prevent your score from being included in the archive.
__________________________________________________________________________________________
-

**TO SUBMIT**: You must post the name you want listed beside the score (can be your reddit /u/), the gamemode of the score, and proof of the score. **Proof *MUST* be either a full screenshot of the deathscreen or gameplay, or a video of gameplay. You may also submit your score in the Diepio World Records server [here](http://bit.ly/WRA-Discord).**
&nbsp;

*If you are found using photoshop, scripting, extensions, hacking, or any other methods of faking a highscore, your score will be revoked and you could be banned from submitting any more scores.*
&nbsp;

" *We'd like to let everyone know that we will start permanently banning anyone running a modified game client, no matter what it is for. It is trivial to detect changes to the game, and we will do our best to ensure no one has an unfair advantage.* " - [Developer changelog, June 11, 2016](https://www.reddit.com/r/Diepio/comments/4ljlxa/can_we_get_a_changelog_archive_thread_for/)
&nbsp;

Class|@foreach ($gamemodes as $gamemode)@if($loop->last){{$gamemode->name}}@else{{($gamemode->name)}}|@endif{{-- --}}@endforeach

    :---|@foreach ($gamemodes as $gamemode)@if($loop->last):---@else :---|@endif{{-- --}}@endforeach

@foreach ($allrecords as $recordsbytankid)
    {{$recordsbytankid[0]->tankname}}|<?php $pos = 0 ?> @foreach($gamemodes as $gamemode) @if( isset($recordsbytankid[$pos]) and $recordsbytankid[$pos]->gamemode_id==$gamemode->id)[{{str_replace(array('|','*','^','_','#','[',']','(',')'),array('\|','\*','\^','\_','\#','\[','\]','\(','\)'),$recordsbytankid[$pos]->name)}} _{{$recordsbytankid[$pos]->score}}_]({{$recordsbytankid[$pos]->links[0]}})@if(count($recordsbytankid[$pos]->links)>1){{-- We have more than one proof.--}}@for($i=1;$i<count($recordsbytankid[$pos]->links);$i++)^[{{$i+1}}]({{$recordsbytankid[$pos]->links[$i]}})  @endfor @endif|<?php  $pos++  ?> {{-- Okay, we had a record for the gamemode, time to increase the counter --}} @else @if($loop->last) @else |{{-- No record for the gamemode found. We just create an empty column --}} @endif @endif @endforeach 
@endforeach
    **Dead Classes** | | |
~~Mega Smasher~~ | [☢ 1.11M](http://imgur.com/gallery/lbyOh) | [uvwxyz 368k](http://imgur.com/AsSX0Nm) | X
~~Predator~~ | [YOBA 283k](https://cdn.discordapp.com/attachments/222132681394225155/226264896185040896/YOBA283137.png) | [✘ 330k](http://m.imgur.com/a/ViHyS) | X
~~X Hunter~~ | [/u/JezzPanda 548k](http://imgur.com/a/S36ZL) | [YOBA 417k](https://cdn.discordapp.com/attachments/214953543558234115/220044236479791105/YOBA417176.png) | [{❂}LinkNPkmn 206k](https://cdn.discordapp.com/attachments/220900206256848897/220965503139577856/Screenshot_20160815-154316.png)
&nbsp;

MOBILE

CLASS | MOBILE FFA | MOBILE TDM |
--------|---------------|----------------|
Annihilator | X | X
Assassin | [{❂}LinkNPkmn 107k](https://cdn.discordapp.com/attachments/220900206256848897/221189248806551553/Screenshot_20160831-082857.png) | X
Auto Gunner | [INDIA 113k](https://cdn.discordapp.com/attachments/222132681394225155/244567384533237760/Screenshot_2016-11-06-02-28-58-258_com.miniclip.diep.io.png) | X
Auto Trapper | X | X
Auto 3 | X | X
Auto 5 | [INDIA 202k](https://cdn.discordapp.com/attachments/222132681394225155/244559124170407938/Screenshot_2016-11-06-01-59-26-368_com.miniclip.diep.io.png) | X
Basic Tank | [LeLnoob 138.4k](https://i.imgur.com/zOCLlCQ.png) | [Josh Killer 80k](https://cdn.discordapp.com/attachments/222132681394225155/230667595764727808/Screenshot_2016-09-28-20-36-15.png)
Battleship | X | X
Booster | [foenix000 711k](https://i.reddituploads.com/606d926d50a1440f93d68f8ae36efb93?fit=max&h=1536&w=1536&s=8fa342c7ffccadbddc0920ea09e83673) | [(❂) Yappat 280k](https://cdn.discordapp.com/attachments/222132681394225155/232792655287812098/IMG_4073.PNG)
Destroyer | [Twisted Fate 159k](http://imgur.com/CDi3awY) | [lightning_po 106k](https://cdn.discordapp.com/attachments/222132681394225155/228438442252566528/Screenshot_2016-09-22-03-50-25.png)
Fighter | [Jake78Official 607k](https://i.reddituploads.com/0f758a4b6f5841abaa1b010153d2f5c0?fit=max&h=1536&w=1536&s=29e5a9ad065d224d3a1172be0462bcde) | [(❂) Yappat 271k](https://cdn.discordapp.com/attachments/222132681394225155/232355649961459712/IMG_4058.PNG)
Flank Guard | [[RDT] Do It 81k](https://i.redd.it/wfvxdguhivpx.png) | [N{❂}ahTh3PandaTank 191k](https://cdn.discordapp.com/attachments/218766686612881410/220624351001575424/IMG_7344.PNG)
Gunner |  [Link1N1Pkmn 101k](http://prnt.sc/c9gblu) | [Josh Killer 77k](https://cdn.discordapp.com/attachments/222132681394225155/229149079970512897/Screenshot_2016-09-24-15-58-18.png)
Gunner Trapper | [Pleb 153k](http://imgur.com/gallery/uhnydkg) | [Josh Killer 172k](https://cdn.discordapp.com/attachments/222132681394225155/228883599129182208/Screenshot_2016-09-23-22-23-44.png)
Hunter | X | X
Hybrid | [Abdelhay-Mrabet 497k](http://imgur.com/gallery/hU5tfZX) | [Pleb 400k](http://imgur.com/gallery/xprismH)
Landmine | X | [Josh Killer 290k](https://cdn.discordapp.com/attachments/222132681394225155/244374251006590976/Screenshot_2016-11-05-16-11-18.png)
Machine gun | [foenix000 521k](https://i.reddituploads.com/2e2847d1c09c40d9bf9f4946dbf12f23?fit=max&h=1536&w=1536&s=cdc2ebbe46501bfde99ee3a0d8a18a60) | [INDIA 216k](https://cdn.discordapp.com/attachments/222132681394225155/242211443624247297/Screenshot_2016-10-30-12-01-30-441_com.miniclip.diep.io.png)
Manager | [Pleb 216k](http://imgur.com/hOqX4Ih) | [~❂~ Xoxinho 226k](http://image.prntscr.com/image/c08863e1b78c4b7abe90bce60d0cd16a.png)
Mega Trapper | X | X
Necromancer | X | [~❂~ Xoxinho 185k](http://image.prntscr.com/image/3ee9c1d74d79418ab98c02c55a3f42ea.png)
Octo Tank | [ᗪυαl ✾ⓂⓉⒽ  318k](https://cdn.discordapp.com/attachments/222132681394225155/223206614327361536/IMG_4036.PNG) | [(❂) Yappat 194k](https://cdn.discordapp.com/attachments/219125765218893826/221411271063502848/IMG_3793.PNG)
Overlord | [Unknown_Fail 250k](https://cdn.discordapp.com/attachments/222132681394225155/244889489158176768/IMG_1700.PNG) | [*unnamed tank* 269k](https://cdn.discordapp.com/attachments/222132681394225155/238497547230904320/Screenshot_2016-10-20-10-28-44.png)
Overseer | [[RDT] Do It 98k](https://i.redd.it/uv5wep89swpx.png) | X
Overtrapper | [[RDT] Do It 171k](https://i.redd.it/irxdwu430xpx.png) | [lightning_po 137k](https://cdn.discordapp.com/attachments/222132681394225155/227334919146307584/Screenshot_2016-09-19-02-46-28.png)
Pentashot | [Unknown_Fail 694k](https://cdn.discordapp.com/attachments/222132681394225155/244642248166211595/IMG_1752.PNG) | [Josh Killer 251k](https://cdn.discordapp.com/attachments/222132681394225155/227262683987050497/FB_IMG_1474254380029.jpg)
Predator | [{❂}LinkNPkmn 170k](https://images-1.discordapp.net/.eJwly0sKwyAQANC7uK-fiU401-gBihjRQOKITlald2-h2wfvLe5xik1U5j43pfZjJhq7nEwjliwLUTlz7MeUiS4VmWOqV248FYD2i0WzOLAYIAT40-q0RefdagBRPdPIuc1K_AJtUHvjHlrDr8jeivh8Ab8RJz0.bjZz32Bchs1IvOkSRefhZDH3nq0.png?width=2000&height=1125) | [Josh Killer 89k](https://cdn.discordapp.com/attachments/222132681394225155/233046395450425344/Screenshot_2016-10-05-10-09-20.png)
Quad Tank | X | [Josh Killer 173k](https://cdn.discordapp.com/attachments/222132681394225155/229066376222998529/Screenshot_2016-09-24-10-32-48.png)
Ranger | [TacoYoutube 73.8k](https://cdn.discordapp.com/attachments/222132681394225155/244917312136675328/Screenshot_2016-11-06-15-09-38.png) | [Josh Killer 233k](https://cdn.discordapp.com/attachments/222132681394225155/227259718119194624/FB_IMG_1474253635307.jpg)
Smasher | X | X
Sniper | [Unknown_Fail 137.7k](https://cdn.discordapp.com/attachments/222132681394225155/244889069144899584/IMG_1784.PNG) | X
Sprayer | [fuk FlyT's wr:) 221k](https://cdn.discordapp.com/attachments/222132681394225155/233440805912576001/Screenshot_2016-10-05-16-01-20.png) | [fuk FlyT's wr:) 220k](https://cdn.discordapp.com/attachments/222132681394225155/233441023207014401/Screenshot_2016-10-05-23-59-30.png)
Spreadshot | [Unknown_Fail 1.1M](https://cdn.discordapp.com/attachments/222132681394225155/244635481462145025/IMG_1743.PNG) | X
Stalker | [Do_It-Diepio 86k](https://i.redd.it/5rqo2czrf4rx.png) | [Josh killer 191k](https://cdn.discordapp.com/attachments/222132681394225155/237571515669807115/Screenshot_2016-10-17-21-45-18.png)
Streamliner | X | X
Trapper | X | X
Tri-Angle | [Unknown_Fail 520k](https://cdn.discordapp.com/attachments/222132681394225155/244641339549941760/IMG_1773.PNG) | [lightning_po 53k](https://cdn.discordapp.com/attachments/222132681394225155/226276592060465152/Screenshot_2016-09-16-04-41-42.png)
Tri-Trapper | X | X
Triple Shot | X | X
Triple Twin | [JohnthekidRS58 506k](http://imgur.com/2R8J4KD) | [Franz_Mueller 111k](http://imgur.com/a/7kxSc)
Triplet | [Twisted Fate 157.4k](http://imgur.com/2mBcsYC) | [Chasing Avi 94k](https://cdn.discordapp.com/attachments/214953543558234115/219583284697497601/Screenshot_2016-08-29-00-03-48.png)
Twin | [Unknown_Fail 400k](https://cdn.discordapp.com/attachments/222132681394225155/244641139976699904/IMG_1713.PNG) | [Bangladesh.Lord 150k](https://cdn.discordapp.com/attachments/222132681394225155/228338485503852544/Screenshot_2016-09-22-07-30-57.png)
Twin Flank | [LeLnoob 776.4k](https://i.imgur.com/qJawboK.png) | X


As a bonus, I'm including other spots for fun:

* Shortest time to reach lvl45: [Anokuu, **4 seconds**](https://www.reddit.com/r/Diepio/comments/4ufxey/level_45_in_four_seconds_world_record/)
* Shortest time to reach 100k: [Fl🔥mes, 1:31 ](https://www.reddit.com/r/Diepio/comments/4tchsi/100k_in_15min/?)
* Shortest time to reach 500k: [sinbad121212 16:20](http://imgur.com/Dyt1fpL)
* Shortest time to reach 700k: [{❂}CHARA 22:38](http://imgur.com/a/BIAKh)
* Shortest time to reach 1M: [YOBA 35:14](https://cdn.discordapp.com/attachments/222132681394225155/234993839415230464/5b014a63fd8107c8.jpg)
* Shortest time to reach 1.5M: [{❂}CHARA 55:06](http://imgur.com/a/iRjxR)
* Shortest time to reach 2M: [adasba 1:36:11](https://www.youtube.com/watch?v=jm8ErpMrvSE)
* Longest survival time (FFA only): [Bela 4:42:17](https://cdn.discordapp.com/attachments/222132681394225155/237714020507844629/2.png)
* Dominator World Record: [RDTOvercraft 1,780](http://imgur.com/lcGo4fs)
* Highest ping: [Zuppyterra 422416.9 ms](https://cdn.discordapp.com/attachments/221791165790420992/222220826345209858/Im_done.jpg)
* **WORLD RECORD SCORE** *(on 6/6/2016)*: [Skorpion-7 [S7] **6.4M** with the Triple Twin](https://www.reddit.com/r/Diepio/comments/4mv3a8/world_record_in_the_game_64m/)
* *Skorpion-7 [S7]'s score will not be included in the list due to the number of updates that have passed since the time it was recorded*
* [Diep.io Achievements!](https://www.reddit.com/r/Diepio/comments/4x3i3w/diepio_achievements_updated/)
&nbsp;

Original WRA by /u/Pyronomy
Co-owned by /u/_jamescb_
</pre>