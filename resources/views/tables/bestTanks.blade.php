<div class="table-responsive">
    <table id="besttankstable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>{{-- The first row shall consist of "Number", "Class" and "Score--}}
            <th class="tankplace">Number</th>

            <th class="diep-gradient-yellow">Class</th>

            <th class="tankscore" data-dynatable-sorts="scorefull">Score (the total score of all gamemodes)</th>
            <th class="nodisplay">scorefull</th>
        </tr>
        </thead>
        <tbody>
        {{--
        --}}
        @foreach ($besttanks as $besttank)
            <tr>{{-- The first column shall be the the ranked number. So if tank x has the greatest score when you summ the gamemodes up, it should be on #1 --}}
                <td>
                    {{$besttank->row}}
                </td>
                {{-- The second column shall always be the tankimage and the tankname. If we are on a small screen, we only display the image
                --}}
                <td>
                    <div class="tanksandname">
                        <span class="scoretanksimage {{str_replace(" ","-",strtolower($besttank->tankname))}}">
                        </span>
                        <span class="mobilehide">{{$besttank->tankname}}
                        </span>
                    </div>
                </td>

                <td><div class="tabletankscore">{{$besttank->score}}</div></td>
                <td class="nodisplay">{{$besttank->scorefull}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>