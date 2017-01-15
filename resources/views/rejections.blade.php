@extends('layouts.app')

@section('title', 'Rejected Submissions from the last seven days')

@section('content')



<div id="alertsContainer">

</div>
<p class="center diep-title-small">Desktop</p>
@include('tables.rejectionsTable',['table_id'=>'rejections-table-desktop','rejections'=>$rejectionsDesktop])

<p class="center diep-title-small">Mobile</p>
@include('tables.rejectionsTable',['table_id'=>'rejections-table-mobile','rejections'=>$rejectionsMobile])



@endsection
@section('customscripts')
    <script>        $(document).ready(function () {


            {{--Initialize dynatable and make sure the columns we declared to use for sorting, interpret the scores as numbers and not as text --}}
               @foreach(array(
                [$rejectionsDesktop,'#rejections-table-desktop'],
                [$rejectionsMobile,'#rejections-table-mobile']
                ) as $gamemodes)
                    $('{{$gamemodes[1]}}').dynatable({
                readers: {
                    'sort{{str_replace("-","","sortsubmissionscore")}}': function (el, record) {
                        return Number(el.innerHTML) || 0;
                    },
                },
                @if ($loop->first)
                dataset: {
                    perPageDefault: 100,
                },
                @else
                dataset: {
                    perPageDefault: 10,
                },
                @endif
            }).bind('dynatable:afterUpdate', function (e, dynatable) {
                updateTableContents(){{-- we must run this again whenever the search function was used because it messes things up --}}
            });
            updateTableContents()
            @endforeach

            $('#recordsubmit').submit(function (event) {
                $('#recordsubmitbtn').addClass('working');
                $('#recordsubmitbtn').html('working...');
            });
        });
    </script>
@endsection



