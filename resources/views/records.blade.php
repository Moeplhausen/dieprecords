@extends('layouts.app')

@section('title', 'Diep.io World Records')


@section('content')
    @include('errors.common')


@section('leftnavitem')
    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-red" data-toggle="modal"
            data-target="#sbmrecord">Submit your record
    </button>
@endsection



{{--  To make this file a bit more readable. The actual modal to submit records is in another file --}}
@include('modals.recordSubmitModal',['gamemodes'=>$gamemodes,'tanknames'=>$tanknames])




<p class="center diep-title">Diep.io World Records</p>


@if (session('status'))
    @foreach(session('status') as $status)
        <div class="alert {{$status->status}}">
            {{ $status->message }}
        </div>
    @endforeach
@endif


<p><button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-green" data-toggle="modal"
        data-target="#sbmrecord">Submit your record
</button></p>


{{-- Put the table with the records by gamemode here --}}
@include('tables.recordstable',['allrecords'=>$allrecords,'gamemodes'=>$gamemodes])


@endsection

@section('customscripts')
    <script>

        function updateTableContents() {
            $('[data-toggle="tooltip"]').tooltip();
        }

        $(document).ready(function () {
            {{--Initialize dynatable and make sure the columns we declared to use for sorting, interpret the scores as numbers and not as text --}}
                $('#scoretable').dynatable({
                readers: {
                    @foreach ($gamemodes as $gamemode)
                    'sort{{str_replace("-","",strtolower($gamemode->name))}}': function (el, record) {
                        return Number(el.innerHTML) || 0;
                    },
                    @endforeach
                }
            }).bind('dynatable:afterUpdate', function (e, dynatable) {
                updateTableContents(){{-- we must run this again whenever the search function was used because it messes things up --}}
            });
            updateTableContents()

            $('#recordsubmit').submit(function (event) {
                $('#recordsubmitbtn').addClass('working');
                $('#recordsubmitbtn').html('working...');
            });
        })
        ;</script>

@endsection




