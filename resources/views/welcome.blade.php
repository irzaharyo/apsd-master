<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}} &mdash; Aplikasi Pengarsipan Surat dan Disposisi | Dinas Pertanian dan Ketahanan Pangan
        Kota Madiun</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/fontawesome-free/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/myBtn.css')}}">
    <!-- Sweet Alert v2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <style>
        /*Carousel animation custom*/
        .carousel.carousel-fade .item {
            -webkit-transition: opacity 0.25s ease-in-out;
            -moz-transition: opacity 0.25s ease-in-out;
            -ms-transition: opacity 0.25s ease-in-out;
            -o-transition: opacity 0.25s ease-in-out;
            transition: opacity 0.25s ease-in-out;
            opacity: 0;
        }

        .carousel.carousel-fade .active.item {
            opacity: 1;
        }

        .carousel.carousel-fade .active.left,
        .carousel.carousel-fade .active.right {
            left: 0;
            z-index: 2;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .carousel.carousel-fade .next,
        .carousel.carousel-fade .prev {
            left: 0;
            z-index: 1;
        }

        .carousel.carousel-fade .carousel-control {
            z-index: 3;
        }

        /* carousel fullscreen */
        .carousel-fullscreen .carousel-inner .item {
            height: 100vh;
            min-height: 600px;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* carousel fullscreen - vertically centered caption*/
        .carousel-fullscreen .carousel-caption {
            top: 50%;
            bottom: auto;
            -webkit-transform: translate(0, -50%);
            -ms-transform: translate(0, -50%);
            transform: translate(0, -50%);
        }

        /* overlay for better readibility of the caption  */
        .carousel-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #000;
            opacity: 0.3;
            transition: all 0.2s ease-out;
        }

        /*Caption custom*/
        .carousel-caption h1, .carousel-caption h2 {
            color: white;
            text-shadow: -3px 3px 4px #000000;
        }

        /*Control custom*/
        .carousel .carousel-control {
            opacity: 0;
        }

        .carousel:hover .carousel-control {
            opacity: 1;
        }
    </style>
</head>
<body>
<div id="carousel-example" class="carousel slide carousel-fullscreen" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($carousels as $row)
            <div class="item" style="background-image: url({{asset('images/carousels/'.$row->image)}});">
                <div class="carousel-overlay"></div>
                <div class="carousel-caption">
                    <a href="{{route('home')}}">
                        <img src="{{asset('images/carousels/web-branding-400.png')}}" class="animated fadeInLeft"
                             alt="logo kota madiun" style="width: 60%">
                    </a>
                    <blockquote style="text-align: left"><h2 class="animated fadeInRight">"{{$row->captions}}"</h2>
                    </blockquote>
                    <button class="myBtn"></button>
                </div>
            </div>
        @endforeach
    </div>

    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
</body>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    $('.carousel-indicators:nth-child(1)').addClass('active');
    $('.item:nth-child(1)').addClass('active');

    $('.carousel').carousel();

    $(".myBtn").on('click', function () {
        window.location.href = '{{route('show.login.form')}}';
    });

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));
</script>
@include('layouts.partials._alert')
</html>