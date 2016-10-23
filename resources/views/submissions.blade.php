@extends('layouts.app')

@section('title', 'Approve or disapprove submitted records')

@section('content')


@section('leftnavitem')
    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-red" onclick=window.location.href="/">
        Records page
    </button>
@endsection


<div id="alertsContainer">

</div>

<div class="table-responsive">
    <table id="submission-table" class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Tank</th>
            <th>Gamemode</th>
            <th>Score</th>
            <th>Proof</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="submissions-list" name="submissions-list">
        @foreach ($submissions as $submission)
            <tr>
                <td>{{$submission[0]->name}}</td>
                <td>
                    <div class="scoretanksimage {{str_replace(" ","-",strtolower($submission[0]->tankname))}}"></div>
                    <span class="mobilehide">{{$submission[0]->tankname}}</span>
                </td>
                <td>{{$submission[0]->gamemode}}</td>
                <td><input type="number" class="form-control" name="score" id="score" value="{{$submission[0]->score}}"
                           required></td>
                <td><a href="{{$submission[0]->link}}" data-toggle="lightbox" data-gallery="hidden{{$submission[0]->id}}">lightbox</a>
                    @if(count($submission)>1) {{-- We have more than one proof. We add them invisible to the lightboxgallery --}}
                    @for($i=1;$i<count($submission);$i++)
                        <div data-toggle="lightbox" data-gallery="hidden{{$submission[0]->id}}" data-remote="{{$submission[$i]->link}}"></div>
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

@endsection
@section('customscripts')
    <script>$(document).ready(function () {
        });</script>
@endsection



