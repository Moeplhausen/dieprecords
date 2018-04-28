<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="description"
          content="World Records site for the browsergame http://diep.io. Submit your World Record here!">
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
        <div class="collapse navbar-toggleable-xs clearfix" id="navbar-header">
            <span class="nav navbar-nav">
                <a class="btn btn-primary btn-lg btn-diep diep-gradient-red" href={{route('records')}}>
                      Records
                </a>
                <a class="btn btn-primary btn-lg btn-diep diep-gradient-yellow" href={{route('statistics')}}>
                      Statistics
                </a>
                </span>
            <span class="float-xs-none">
                <a class="btn btn-primary btn-lg btn-diep diep-gradient-blue"
                   href={{route('info')}}>
                    API
                </a>
                                <a class="btn btn-primary btn-lg btn-diep diep-gradient-yellow"
                                   href={{route('top100')}}>
                    TOP100
                </a>
            </span>
            <span class="float-xs-right">
                <a class="btn btn-primary btn-lg btn-diep diep-gradient-red"
                   href={{route('rejections')}}>Rejections
                </a>
                <a class="btn btn-primary btn-lg btn-diep diep-gradient-yellow"
                   href={{route('submissions')}}>Submissions
                </a>
                @if(Auth::guest())
                    <a class="btn btn-primary btn-lg btn-diep diep-gradient-blue" data-toggle="modal"
                       data-target="#managerlogin">Manager login
                    </a>
                @else
                    <a class="btn btn-primary btn-lg btn-diep diep-gradient-red"
                       onclick="$('#logout-form').submit()">
                        Logout
                    </a>
                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
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
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
      m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

  ga('create', 'UA-86559510-1', 'auto');
  ga('send', 'pageview');

</script>

<script src="{{  asset(elixir('js/app.js')) }}"></script>

<script>

  var DECIDESUBMISSIONURL = "{{route('decidesubmission')}}"

  function updateTableContents() {
    $('[data-toggle="tooltip"]').tooltip();
    $(".button-x-corner").unbind('click');
    $('.button-x-corner').click(function () {
      console.log("click");
      $(this).attr('disabled', 'true');
      var proof_id = $(this).attr('submission');
      var score = $(this).attr('score');
      var name = $(this).attr('submittername');

      $.ajax({
        type: 'POST',
        url: DECIDESUBMISSIONURL,
        data: {id: proof_id, answ: 0, score: score, name: name, decided: 0},
        success: function (data, textStatus, xhr) {
          //console.log(data);
          console.log(xhr);
          if (xhr.status == '200') {
            $('#alertsContainer').append("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
          }
          else {
            $('#alertsContainer').append("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
          }
        }
      });
    })


  }

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
