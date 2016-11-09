Class|@foreach ($gamemodes as $gamemode)@if($loop->last){{$gamemode->name}}@else{{($gamemode->name)}}|@endif{{-- --}}@endforeach

:---|@foreach ($gamemodes as $gamemode)@if($loop->last):---@else :---|@endif{{-- --}}@endforeach

@foreach ($allrecords as $recordsbytankid)
    {{$recordsbytankid[0]->tankname}}|<?php $pos = 0 ?> @foreach($gamemodes as $gamemode) @if( isset($recordsbytankid[$pos]) and $recordsbytankid[$pos]->gamemode_id==$gamemode->id)[{{str_replace(array('|','*','^','_','#','[',']','(',')'),array('\|','\*','\^','\_','\#','\[','\]','\(','\)'),$recordsbytankid[$pos]->name)}} {{$recordsbytankid[$pos]->score}}]({{$recordsbytankid[$pos]->submittedlink}})|<?php  $pos++  ?> {{-- Okay, we had a record for the gamemode, time to increase the counter --}} @else @if($loop->last) @else |{{-- No record for the gamemode found. We just create an empty column --}} @endif @endif @endforeach

@endforeach