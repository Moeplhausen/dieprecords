{{-- Create a table for all the scores. The table should be the form of n x m. Where n=1(header)+NumberOfTanks and m=1(ClassName)+NumberOfGamemodes*2 --}}
<div class="table-responsive">
    <table id="{{$tablename}}" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>{{-- The first row shall consist of "Tank" and the names of all the gamemodes in the database--}}
            <th class="diep-gradient-yellow">Tank</th>
            {{-- Loop through each gamemode and create 2 columns.
                The first column will consist of score and name (like 12.12M Moepl) and is basically that what the user sees.
                The second row will always be the raw score (unformatted). That column will be invisible but used for sorting by dynatable
            --}}
            @foreach ($gamemodes as $gamemode)
                <th class="th{{$gamemode->name}}"
                    data-dynatable-sorts="sort{{str_replace("-","",strtolower($gamemode->name))}}">{{$gamemode->name}}</th>
                <th class="nodisplay">sort{{str_replace("-","",strtolower($gamemode->name))}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        {{-- Now we loop through each record we have. Thankfully, they are sorted by tankid and gamemode. So we "just" need to print them out.
        --}}
        @foreach ($allrecords as $recordsbytankid)
            <tr>
                {{-- The first column shall always be the tankimage and the tankname. If we are on a small screen, we only display the image
                --}}
                <td>
                    <div class="tanksandname">
                        <span class="scoretanksimage {{str_replace(" ","-",strtolower($recordsbytankid[0]->tankname))}}">
                        </span>
                        <span class="mobilehideimportant">{{$recordsbytankid[0]->tankname}}
                        </span>
                    </div>
                </td>
                {{-- Now we need to print the actual scores. The problem is that we might now have scores for every gamemode.
                    As a consequence, we need to initialize a counter to make sure we print the records we have into the correct column.
                    If we don't have a record for the gamemode, we create two empty columns.
                --}}
                <?php $pos = 0; $lastGamemodeId = -1; ?>


                @foreach($gamemodes as $gamemode)
                    {{--
                        If there are multiple records with the same score (same gamemode, tank), we skip the ones after the first
                    --}}
                    @while(count($recordsbytankid)>$pos and $recordsbytankid[$pos]->gamemode_id==$lastGamemodeId)
                        <?php  $pos++  ?>
                    @endwhile
                    @if(count($recordsbytankid)>$pos and isset($recordsbytankid[$pos]) and $recordsbytankid[$pos]->gamemode_id==$gamemode->id)
                        <?php $lastGamemodeId = $gamemode->id; ?>
                        <td class="record-entry-table-td"> {{-- Okay, we have a record for the gamemode. We wrap the other stuff (score and name) around a span to
                                 display a tooltip which shows the score, who approved the record and when it was approved.
                                 If we don't know when it was approved, we only display the name
                              --}}
                            @if(Auth::check())
                                <input class="button-x-corner" score="{{$recordsbytankid[$pos]->scorefull}}"
                                       submittername="{{$recordsbytankid[$pos]->name}}"
                                       submission="{{$recordsbytankid[$pos]->proof_id}}" type="button" value="X">
                            @endif
                            <span data-toggle="tooltip"
                                  data-html="true"
                                  data-placement="top"
                                  title="Submitted by: {{$recordsbytankid[$pos]->name}}<br>Score: {{number_format($recordsbytankid[$pos]->scorefull)}}<br>Approved by: {{$recordsbytankid[$pos]->approvername}}
                                  @if(isset($recordsbytankid[$pos]->submittedDate))
                                          <br>Date: <span class='approvedDateTooltip'>{{$recordsbytankid[$pos]->submittedDate}}</span>
                                  @endif
                                          ">
                                    {{--Okay, we got the tooltip done.
                                    Now we need to actually display the score and name. We use a link for that and open it when pressed with lightbox --}}
                                <a href="{{$recordsbytankid[$pos]->submittedlink}}"
                                   data-toggle="lightbox"
                                   data-remote="{{$recordsbytankid[$pos]->links[0]}}"
                                   data-gallery="hidden{{$recordsbytankid[$pos]->proof_id}}"
                                   class="{{$recordsbytankid[$pos]->cssExtra}}"> {{-- if the record is best by gamemode or overall, we want to add extra styles --}}

                                    <span class="tabletankscore">{{$recordsbytankid[$pos]->score}}
                                     </span>
                                     <span class="tabletankname mobilehide"> {{-- If we are on small devices,
                                                                                only display the score and not the name.
                                                                                The name should use a smaller font anyway --}}
                                         <small>{{$recordsbytankid[$pos]->name}}</small>
                                    </span>
                                </a>
                                @if(count($recordsbytankid[$pos]->links)>1) {{-- We have more than one proof. We add them invisible to the lightboxgallery --}}
                                @for($i=1;$i<count($recordsbytankid[$pos]->links);$i++)
                                    <div data-toggle="lightbox"
                                         data-gallery="hidden{{$recordsbytankid[$pos]->proof_id}}"
                                         data-remote="{{$recordsbytankid[$pos]->links[$i]}}"></div>
                                @endfor
                                @endif
                            </span>
                        </td>
                        <td class="nodisplay">{{$recordsbytankid[$pos]->scorefull}}</td>
                        <?php  $pos++  ?> {{-- Okay, we had a record for the gamemode, time to increase the counter --}}
                    @else
                        <td></td> {{-- No record for the gamemode found. We just create 2 empty columns --}}
                        <td class="nodisplay"></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>