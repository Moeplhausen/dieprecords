@extends('layouts.app')

@section('title', 'Approve or disapprove submitted records')

@section('content')


@section('leftnavitem')

@endsection


<div id="alertsContainer">

</div>
<p class="center diep-title-small">Desktop</p>
@include('tables.submissionTable',['table_id'=>'submission-table-desktop','submissions'=>$submissionsDesktop])

<p class="center diep-title-small">Mobile</p>
@include('tables.submissionTable',['table_id'=>'submission-table-mobile','submissions'=>$submissionsMobile])

<div class="exporter">
    <a class="btn btn-xs btn-diep diep-gradient-red" href="{{route('apirecords')}}/markdown">Reddit Markdown</a>
</div>


@endsection
@section('customscripts')
    <script>$(document).ready(function () {
        });</script>
@endsection



