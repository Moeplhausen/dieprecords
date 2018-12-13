<div class="table-responsive">
    <table id="{{$table_id}}" class="table table-condensed">
        <thead>
        <tr>
            <th>Name</th>
            <th data-dynatable-sorts="sortsubmissiontank">Tank
            </th>{{-- The tank icon might mess with the sorting, so we use an extra field for that --}}
            <th class="nodisplay">sortsubmissiontank</th>
            <th>Gamemode</th>
            <th data-dynatable-sorts="sortsubmissionscore">Score
            </th>{{-- The score is interpreted as a string on default. So we use an extra field for sorting --}}
            <th class="nodisplay">sortsubmissionscore</th>
            <th>Proof</th>
            @if(Auth::check())
                <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody id="submissions-list" name="submissions-list">
        @foreach ($submissions as $submission)
            <tr>
                <td><input type="text" class="form-control" name="inputname" id="inputname"
                           value="{{$submission[0]->name}}"
                           maxlength="25"
                           required>{{--  Display the name of the submitter To allow managers to easily change the name because the submitter typed some garbage --}}
                </td>{{-- Display the name of the submitter --}}
                <td><span style="white-space:nowrap">
                        <div class="scoretanksimage {{str_replace(" ","-",strtolower($submission[0]->tankname))}}{{$submission[0]->world_record?'-tier5':''}}"></div> {{-- Display the image of the tank --}}
                        <span class="mobilehide">{{$submission[0]->tankname}}</span> {{-- small devices should only show the image of the tank and not the name to save space --}}
                    </span>
                </td>
                <td class="nodisplay">{{$submission[0]->tankname}}</td> {{-- The column we use for sorting tank names --}}
                <td>{{$submission[0]->gamemode}}</td> {{-- gamemode name --}}
                <td><input type="number"
                           class="form-control copyMe{{$submission[0]->id}} listscore{{$submission[0]->id}}"
                           name="score" id="score"
                           value="{{$submission[0]->score}}"
                           required>{{-- Display the score here. To allow managers to easily change the score because the submitter typed it wrong/incomplete, we make it in input which will be submitted when approved/denied --}}
                </td>
                <td class="nodisplay">{{$submission[0]->score}}</td> {{-- The column to sort scores --}}
                <td><a href="{{$submission[0]->submittedlink}}"
                       {{-- if the proof is clicked, we open a modal with lightbox in it --}}
                       data-toggle="lightbox"
                       data-remote="{{$submission[0]->link}}"
                       data-gallery="hidden{{$submission[0]->id}}"
                       data-title="<a href='{{$submission[0]->submittedlink}}'>Submitted link by User</a>"
                       data-footer="@include('snippets.lightboxFooter',['submission'=>$submission[0]])" {{-- in the footer of lightbox should be anoter input that is synced to the score field. This should allow managers to easily update the score while seeing the actual proof on the same window(modal) --}}
                    >lightbox</a>
                    @if(count($submission)>1) {{-- We have more than one proof. We add them invisible to the lightboxgallery --}}
                    @for($i=1;$i<count($submission);$i++)
                        <div data-toggle="lightbox" data-gallery="hidden{{$submission[0]->id}}"
                             data-remote="{{$submission[$i]->link}}"
                             data-footer="@include('snippets.lightboxFooter',['submission'=>$submission[0]])"></div>
                    @endfor
                    @endif
                </td>
                @if(Auth::check())
                    <td><span style="white-space:nowrap">
                    <button class="btn btn-success btn-xs btn-detail decisionbtnfucker approve-submission"
                            value="{{$submission[0]->id}}">Approve
                    </button>
                    <button class="btn btn-danger btn-xs btn-delete decisionbtnfucker deny-submission"
                            value="{{$submission[0]->id}}">Deny
                    </button></span>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>