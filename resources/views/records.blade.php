@extends('layouts.app')

@section('title', 'Diep.io World Records')


@section('content')
    @include('errors.common')



{{--  To make this file a bit more readable. The actual modal to submit records is in another file --}}
@include('modals.recordSubmitModal',['gamemodesDesktop'=>$gamemodesDesktop,'gamemodesMobile'=>$gamemodesMobile,'tanknames'=>$tanknames])


<p class="center diep-title">Diep.io World Records</p>

@if (session('status'))
    @foreach(session('status') as $status)
        <div class="alert {{$status->status}}">
            {{ $status->message }}
        </div>
    @endforeach
@endif


<p>
    <a class="btn btn-primary btn-lg btn-diep diep-gradient-green" data-toggle="modal"
            data-target="#sbmrecord">Submit your record
    </a>
</p>

<p class="center diep-title-small">Desktop</p>
{{-- Put the table with the Desktop records by gamemode here --}}
@include('tables.recordstable',['tablename'=>'scoretableDesktop','allrecords'=>$allrecordsDesktop,'gamemodes'=>$gamemodesDesktop])

<p class="center diep-title-small">Mobile</p>
{{-- Put the table with the Desktop records by gamemode here --}}
@include('tables.recordstable',['tablename'=>'scoretableMobile','allrecords'=>$allrecordsMobile,'gamemodes'=>$gamemodesMobile])


@endsection

@section('customscripts')
    <script>

        function updateTableContents() {
            $('[data-toggle="tooltip"]').tooltip();
        }

        $(document).ready(function () {

            {{--Initialize dynatable and make sure the columns we declared to use for sorting, interpret the scores as numbers and not as text --}}
                        @foreach(array(
                [$gamemodesDesktop,'#scoretableDesktop'],
                [$gamemodesMobile,'#scoretableMobile']
                ) as $gamemodes)
                    $('{{$gamemodes[1]}}').dynatable({
                readers: {
                    @foreach ($gamemodes[0] as $gamemode)
                    'sort{{str_replace("-","",strtolower($gamemode->name))}}': function (el, record) {
                        return Number(el.innerHTML) || 0;
                    },
                    @endforeach
                },
                dataset: {
                    perPageDefault: 100,
                }
            }).bind('dynatable:afterUpdate', function (e, dynatable) {
                updateTableContents(){{-- we must run this again whenever the search function was used because it messes things up --}}
            });
            updateTableContents()
            @endforeach

            $('#recordsubmit').submit(function (event) {
                $('#recordsubmitbtn').addClass('working');
                $('#recordsubmitbtn').html('working...');
            });
        })
        ;</script>

@endsection




