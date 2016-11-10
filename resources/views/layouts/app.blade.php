<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="description" content="Unofficial World Records site for the game diep.io Submit your records here!">
    <meta name="keywords" content="diep.io, records, world records, WR">
    <meta name="rating" content="safe for kids">
    <meta name="no-email-collection" content="http://www.metatags.nl/nospamharvesting">
    <meta name="reply-to" content="webmaster@moepl.eu">
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
                <a  class="btn btn-primary btn-lg btn-diep diep-gradient-red" href="/">
                      Records page
                </a>
                <a class="btn btn-primary btn-lg btn-diep diep-gradient-yellow" href="/statistics">
                      Statistics
                </a>
                </span>
            <span class="float-xs-right">
                @if(Auth::guest())
                    <a class="btn btn-primary btn-lg btn-diep diep-gradient-blue" data-toggle="modal"
                            data-target="#managerlogin">Manager login
                    </a>
                @else
                    <a  class="btn btn-primary btn-lg btn-diep diep-gradient-blue"
                            href="/submissions">
                        Submitted Records
                    </a>
                    <a class="btn btn-primary btn-lg btn-diep diep-gradient-red"
                            onclick="$('#logout-form').submit()">
                        Logout
                    </a>
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


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-86559510-1', 'auto');
  ga('send', 'pageview');

</script>

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
            perPageDefault: 10,
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
