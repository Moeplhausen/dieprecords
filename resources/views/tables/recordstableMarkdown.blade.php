<pre>&nbsp;
Class|@foreach ($gamemodes as $gamemode)@if($loop->last){{$gamemode->name}}@else{{($gamemode->name)}}|@endif{{-- --}}@endforeach

    :---|@foreach ($gamemodes as $gamemode)@if($loop->last):---@else :---|@endif{{-- --}}@endforeach

@foreach ($allrecords as $recordsbytankid)
    {{$recordsbytankid[0]->tankname}}|<?php $pos = 0 ?> @foreach($gamemodes as $gamemode) @if( isset($recordsbytankid[$pos]) and $recordsbytankid[$pos]->gamemode_id==$gamemode->id)[{{str_replace(array('|','*','^','_','#','[',']','(',')'),array('\|','\*','\^','\_','\#','\[','\]','\(','\)'),$recordsbytankid[$pos]->name)}} {{$recordsbytankid[$pos]->score}}]({{$recordsbytankid[$pos]->submittedlink}})|<?php  $pos++  ?> {{-- Okay, we had a record for the gamemode, time to increase the counter --}} @else @if($loop->last) @else |{{-- No record for the gamemode found. We just create an empty column --}} @endif @endif @endforeach
    
@endforeach
    **Dead Classes** @foreach ($gamemodes as $gamemode)| @endforeach

~~Mega Smasher~~ | [☢ 1.11M](http://imgur.com/gallery/lbyOh) | [uvwxyz 368k](http://imgur.com/AsSX0Nm) | X| X
~~Predator~~ | [YOBA 283k](https://cdn.discordapp.com/attachments/222132681394225155/226264896185040896/YOBA283137.png) | [✘ 330k](http://m.imgur.com/a/ViHyS) | X| X
~~X Hunter~~ | [/u/JezzPanda 548k](http://imgur.com/a/S36ZL) | [YOBA 417k](https://cdn.discordapp.com/attachments/214953543558234115/220044236479791105/YOBA417176.png) | [{❂}LinkNPkmn 206k](https://cdn.discordapp.com/attachments/220900206256848897/220965503139577856/Screenshot_20160815-154316.png)| X
&nbsp;</pre>