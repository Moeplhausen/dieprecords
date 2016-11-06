Class|@foreach ($gamemodes as $gamemode)@if($loop->last){{$gamemode->name}}@else{{($gamemode->name)}}|@endif{{-- --}}@endforeach</br>
:---|@foreach ($gamemodes as $gamemode)@if($loop->last):---@else :---|@endif{{-- --}}@endforeach<br>
@foreach ($allrecords as $recordsbytankid)
    {{$recordsbytankid[0]->tankname}}|
    <?php $pos = 0 ?>
    @foreach($gamemodes as $gamemode)
        @if( isset($recordsbytankid[$pos]) and $recordsbytankid[$pos]->gamemode_id==$gamemode->id)
            [{{$recordsbytankid[$pos]->name}} _{{$recordsbytankid[$pos]->score}}_]({{$recordsbytankid[$pos]->links[0]}})
            @if(count($recordsbytankid[$pos]->links)>1) {{-- We have more than one proof.--}}
            @for($i=1;$i<count($recordsbytankid[$pos]->links);$i++)
                ^[{{$i+1}}]({{$recordsbytankid[$pos]->links[$i]}})
            @endfor

            @endif
            |
            <?php  $pos++  ?> {{-- Okay, we had a record for the gamemode, time to increase the counter --}}
        @else
            @if($loop->last)
                @else
            |{{-- No record for the gamemode found. We just create an empty column --}}
                @endif
        @endif
    @endforeach<br>
@endforeach