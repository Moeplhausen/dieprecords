@extends('layouts.app')
@section('title', 'Diep.io World Records')
@section('content')
    @if(count($userworldrecords)>0)

    @else
    @endif

    @if(count($formeruserworldrecords)>0)

    @endif

@endsection