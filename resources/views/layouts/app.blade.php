<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"> -->
    <!-- css -->
    <!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.0.0/ekko-lightbox.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/ekko-lightbox.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/tanks.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.dynatable.css') }}">
    -->
    <link rel="stylesheet" href="{{ URL::asset('css/all.css') }}">
    <!-- Styles -->
    <style>
    </style>
</head>
<body>
<div class="container">

    <nav class="navbar topmenu record-submit">
        <div class="col-sm-6">
            @yield('leftnavitem')
        </div>
        <div class="col-sm-6">
            @if(Auth::guest())
                <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-blue" data-toggle="modal"
                        data-target="#managerlogin">Manager login
                </button>
            @else
                <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-blue" onclick=window.location.href="/submissions">Submitted Records</button>
                <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-red" onclick="$('#logout-form').submit()">
                    Logout
                </button>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

            @endif
        </div>

    </nav>


    @yield('content')
</div>
<!--
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/tether.min.js') }}"></script>

<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/ekko-lightbox.min.js') }}"></script>

<script src="{{ URL::asset('js/jquery.dynatable.js') }}"></script>
<script src="{{ URL::asset('js/ajaxfucker.js') }}"></script>
-->
<script src="{{ URL::asset('js/all.js') }}"></script>

<script>

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
    });

    $.dynatableSetup({
        dataset: {
            perPageDefault: 20,
        }
    });



    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
        });
    });


</script>
@yield('customscripts')
</body>
</html>