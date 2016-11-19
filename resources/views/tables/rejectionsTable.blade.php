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
            <th>Submitted link</th>
            <th>Submission Date</th>

        </tr>
        </thead>
        <tbody id="submissions-list" name="submissions-list">
        @foreach ($rejections as $rejection)
            <tr>
                <td>{{$rejection[0]->name}}</td>{{-- Display the name of the submitter --}}
                <td><span style="white-space:nowrap">
                        <div class="scoretanksimage {{str_replace(" ","-",strtolower($rejection[0]->tankname))}}"></div> {{-- Display the image of the tank --}}
                        <span class="mobilehide">{{$rejection[0]->tankname}}</span> {{-- small devices should only show the image of the tank and not the name to save space --}}
                    </span>
                </td>
                <td class="nodisplay">{{$rejection[0]->tankname}}</td> {{-- The column we use for sorting tank names --}}
                <td>{{$rejection[0]->gamemode}}</td> {{-- gamemode name --}}
                <td>{{$rejection[0]->score}}
                </td>
                <td class="nodisplay">{{$rejection[0]->score}}</td> {{-- The column to sort scores --}}
                <td><a href="{{$rejection[0]->submittedlink}}">link</a></td>
                <td>{{$rejection[0]->submitted_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>