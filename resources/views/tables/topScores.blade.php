<div class="table-responsive">
    <table id="topscorestable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>{{-- The first row shall consist of "Number", "Class" and "Score--}}
            <th class="tankplace">Place</th>

            <th class="diep-gradient-yellow">Tank</th>

            <th class="diep-gradient-yellow">User</th>


            <th class="tankscore" data-dynatable-sorts="scorefull">Score</th>
            <th class="nodisplay">scorefull</th>
        </tr>
        </thead>
        <tbody>
        {{--
        --}}
        @foreach ($topRecords as $besttank)
            <tr>{{-- The first column shall be the the ranked number. So if tank x has the greatest score when you summ the gamemodes up, it should be on #1 --}}
                <td>
                    {{$besttank->row}}
                </td>
                {{-- The second column shall always be the tankimage and the tankname. If we are on a small screen, we only display the image
                --}}
                <td>
                    <div class="tanksandname">
                        <span class="scoretanksimage {{str_replace(" ","-",strtolower($besttank->tank))}}{{$besttank->world_record?'-tier5':''}}">
                        </span>
                        <span class="mobilehide">{{$besttank->tank}}
                        </span>
                    </div>
                </td>
                <td>
                    <span class="username">{{$besttank->name}}
                        @if(Auth::check())
                            <input class="button-x-corner" score="{{$besttank->scorefull}}"
                                   submittername="{{$besttank->name}}"
                                   submission="{{$besttank->id}}" type="button" value="X">
                        @endif

                    </span>
                </td>

                <td>
                    <div class="tabletankscore">


                        <span data-toggle="tooltip"
                              data-html="true"
                              data-placement="top"
                              title="Score: {{$besttank->scorefull}} <br>Approved by: {{$besttank->approvername}}
                              @if(isset($besttank->created_at))
                                      <br>Date: <span class='approvedDateTooltip'>{{$besttank->created_at}}</span>
                                  @endif">
                                    {{--Okay, we got the tooltip done.
                                    Now we need to actually display the score and name. We use a link for that and open it when pressed with lightbox --}}
                            <a href="{{$besttank->submittedlink}}">{{$besttank->score}}</a>

                            </span>


                    </div>
                </td>

                <td class="nodisplay">{{$besttank->scorefull}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>