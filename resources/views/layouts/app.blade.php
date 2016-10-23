<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png" href="{{elixir('images/favicon.png')}}" sizes="32x32">
    {{-- Styles --}}
    <link rel="stylesheet" href="{{  elixir('css/app.css')}}">


    <style>
        @yield('customstyle')
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-light">
        <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbar-header"
                aria-controls="navbar-header" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-toggleable-xs" id="navbar-header">
            <span class="nav navbar-nav">
                @yield('leftnavitem')
                </span>
            <span class="float-xs-right">
                @if(Auth::guest())
                    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-blue" data-toggle="modal"
                            data-target="#managerlogin">Manager login
                    </button>
                @else
                    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-blue"
                            onclick=window.location.href="/submissions">
                        Submitted Records
                    </button>
                    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-red"
                            onclick="$('#logout-form').submit()">
                        Logout
                    </button>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @endif
            </span>
        </div>
    </nav>
    @include('modals.loginModal')

    @yield('content')
</div>




<script src="{{  asset(elixir('js/app.js')) }}"></script>

<script>

    $(function () {
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


    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
        });
    });


</script>
@yield('customscripts')
</body>
</html>
