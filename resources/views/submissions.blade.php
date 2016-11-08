@extends('layouts.app')

@section('title', 'Approve or disapprove submitted records')

@section('content')


@section('leftnavitem')

@endsection


<div id="alertsContainer">

</div>

<div class="table-responsive">
    <table id="submission-table" class="table">
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
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="submissions-list" name="submissions-list">
        @foreach ($submissions as $submission)
            <tr>
                <td>{{$submission[0]->name}}</td>{{-- Display the name of the submitter --}}
                <td>
                    <div class="scoretanksimage {{str_replace(" ","-",strtolower($submission[0]->tankname))}}"></div> {{-- Display the image of the tank --}}
                    <span class="mobilehide">{{$submission[0]->tankname}}</span> {{-- small devices should only show the image of the tank and not the name to save space --}}
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
                <td><a href="{{$submission[0]->link}}"
                       {{-- if the proof is clicked, we open a modal with lightbox in it --}}
                       data-toggle="lightbox"
                       data-gallery="hidden{{$submission[0]->id}}"
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
                <td>
                    <button class="btn btn-success btn-xs btn-detail decisionbtnfucker approve-submission"
                            value="{{$submission[0]->id}}">Approve
                    </button>
                    <button class="btn btn-danger btn-xs btn-delete decisionbtnfucker deny-submission"
                            value="{{$submission[0]->id}}">Deny
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="exporter">
    <button type="button" class="btn btn-xs btn-diep diep-gradient-red" onclick=window.location.href="/api/records/markdown">Reddit Markdown</button>
</div>


@endsection
@section('customscripts')
    <script>$(document).ready(function () {
        });</script>
@endsection



