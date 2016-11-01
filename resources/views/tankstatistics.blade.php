@extends('layouts.app')

@section('title', 'Diep.io Best Tanks Statistics')


@section('content')
    @include('errors.common')


@section('leftnavitem')

@endsection


<p class="center diep-title">Most Successfull Diep.io WR Tanks</p>

@if (session('status'))
    @foreach(session('status') as $status)
        <div class="alert {{$status->status}}">
            {{ $status->message }}
        </div>
    @endforeach
@endif

{{-- Put the table with best tanks here --}}
@include('tables.bestTanks',['besttanks'=>$besttanks])


@endsection

@section('customscripts')
    <script>


        $(document).ready(function () {
            {{--Initialize dynatable and make sure the columns we declared to use for sorting, interpret the scores as numbers and not as text --}}
            $('#besttankstable').dynatable({
                readers: {
                    'scorefull': function (el, record) {
                        return Number(el.innerHTML) || 0;
                    },
                    'number': function (el, record) {
                        return Number(el.innerHTML) || 0;
                    },
                }
            });


        });
    </script>

@endsection




