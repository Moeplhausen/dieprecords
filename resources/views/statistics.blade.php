@extends('layouts.app')

@section('title', 'Statistics')


@section('content')
    @include('errors.common')


@section('leftnavitem')

@endsection



@if (session('status'))
    @foreach(session('status') as $status)
        <div class="alert {{$status->status}}">
            {{ $status->message }}
        </div>
    @endforeach
@endif

<div id="statisticstabnav">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item ">
            <a class="nav-link active" data-toggle="tab" href="#bestsubmitterspane" role="tab">Best Submitters</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#besttankspane" role="tab">Best Tanks</a>
        </li>
    </ul>
</div>
<div class="tab-content">
    <div class="tab-pane" id="besttankspane" role="tabpanel">
        <p class="center fade diep-title">Most Successfull Diep.io WR Tanks</p>
        {{-- Put the table with best tanks here --}}
        @include('tables.bestTanks',['besttanks'=>$besttanks])
    </div>
    <div class="tab-pane fade in active" id="bestsubmitterspane" role="tabpanel">
        <p class="center diep-title">Most Successfull Diep.io Record holders</p>
        {{-- Put the table with best submitters here --}}
        @include('tables.bestSubmitters',['bestSubmitters'=>$bestSubmitters])
    </div>
</div>

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
            $('#bestsubmitterstable').dynatable({
                readers: {
                    'numberOfWorldRecords': function (el, record) {
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




