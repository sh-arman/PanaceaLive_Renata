<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162782168-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162782168-1');
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{-- Renata  --}}Live Check</title>

    <!-- favicon stuff -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('/favicon/safari-pinned-tab.svg')}}" color="#0058ab">
    <link rel="shortcut icon" href="{{asset('/favicon/favicon.ico')}}">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-config" content="{{asset('/favicon/browserconfig.xml')}}">
    <meta name="theme-color" content="#0058ab">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Magra&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/public/overall.css?v2.0')}}">

</head>

<body class="bg-style" style="height:100vh;font-family: 'Magra', sans-serif;">

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">

        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('images/logos/renata.png')}}" style="max-width:45px;" >
            <img class="ml-2" src="{{asset('images/logos/live_check.png')}}" style="max-width:70px;padding-top:12px;" >
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" style="border:0px;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ml-1 ml-md-4" id="navbarNavAltMarkup">
            <div class="navbar-nav font-weight-bold">
                <a class="nav-item nav-link mr-2 p-2 text-light" href="{{url('/')}}">Home</a>
                <!-- <a class="nav-item nav-link" href="{{url('howto')}}">How To</a> !-->
                <a class="nav-item nav-link mr-2 p-2 text-light" href="https://renata-ltd.com/">Main Website</a>
                {{-- <a class="nav-item nav-link mr-2 p-2 text-light" href="https://panacea.live">Main Website</a> --}}
            </div>
        </div>
    </nav>

    <div style="height:100vh; display: flex;" id="liveCheckDiv">
        @yield('contents')
    </div>

    <div style="height:100vh; display: none;" id="howtos">
        @include('public/howtos')
    </div>
</body>


<script>
    $(".navbar-toggler").click(function(){
        $('.navbar').toggleClass( "navbar-darker" );
        $('.nav-link').toggleClass( "text-center" );
    });
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 1) {
            $(".navbar").css("background-color", "#0059A9");
        } else {
            $(".navbar").css("background-color", "transparent");
        }
    });
    var w = $(window).width(); //viewport height
    if( w < 500 ) //meaning it is probably mobile device, so need to add margin
    {
        $('#howtos').css('margin-top','60px');
    }
window.onload = function() {
  associateIds();
  clicked();
}

function associateIds() {
  var all = document.getElementsByTagName("*");
  var id = -1;
  for (var elem = 0; elem < all.length; elem++) {
    if (all[elem].tagName == "DIV") {
      id++;
      all[elem].dataset.id = id;
    }
  }
}
function clicked() {
  document.body.addEventListener('click', function(evt) {
    var evt = window.event || evt; //window.event for IE
    if (!evt.target) {
      evt.target = evt.srcElement; //extend target property for IE
    }
    var e = evt.target;
    // look for parent div
    while (e && e.tagName != 'DIV') {
       e = e.parentNode;
    }
    if (e) {
        console.log("Clicked");
        $('.collapse').collapse('hide');
    } 
  });
}

</script>

</html>