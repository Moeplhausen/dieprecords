@extends('layouts.app')
@section('content')


@section('leftnavitem')
    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-red" onclick=window.location.href="/">Records page
    </button>
@endsection


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
                <td>{{$submission->name}}</td>
                <td>{{$submission->tankname}}</td>
                <td>{{$submission->gamemode}}</td>
                <td>{{$submission->score}}</td>
                <td><a href="{{$submission->proof_link}}" data-toggle="lightbox">proof</a></td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail decisionbtnfucker approve-submission" value="{{$submission->id}}">Approve</button>
                    <button class="btn btn-danger btn-xs btn-delete decisionbtnfucker deny-submission" value="{{$submission->id}}">Deny</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

        @endsection
        @section('customscripts')
            <script>$(document).ready(function () {
                });</script>
@endsection



