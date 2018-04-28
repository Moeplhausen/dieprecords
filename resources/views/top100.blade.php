@extends('layouts.app')

@section('title', 'Diep.io TOP100 Records')


@section('content')
    @include('errors.common')



    <p class="center diep-title">Diep.io Top 100 Records</p>

    @if (session('status'))
        @foreach(session('status') as $status)
            <div class="alert {{$status->status}}">
                {{ $status->message }}
            </div>
        @endforeach
    @endif


    <p>

    </p>
    <div id="alertsContainer">

    </div>

    @include('tables.topScores',['topRecords'=>$topRecords])
@endsection

@section('customscripts')
    <script>



        $(document).ready(function () {
                    {{--Initialize dynatable and make sure the columns we declared to use for sorting, interpret the scores as numbers and not as text --}}
                    $('#topscorestable').dynatable({
                      readers: {
                        'scorefull': function (el, record) {
                          return Number(el.innerHTML) || 0;
                        },
                        'number': function (el, record) {
                          return Number(el.innerHTML) || 0;
                        },
                      },
                      dataset: {
                        perPageDefault: 100,
                      },
                    }).bind('dynatable:afterUpdate', function (e, dynatable) {
                      updateTableContents(){{-- we must run this again whenever the search function was used because it messes things up --}}
                      //t
                    });
          updateTableContents();
          });


    </script>

@endsection




