<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>
    King Castle, Lake Front By Laksam
  </title>
  <meta name="author" content="King Castle" />
  <meta name="description" content="Experience luxury and comfort at King Castle, Lake Front By Laksam" />
  <meta name="keywords" content="King Castle" />
  <meta name="robots" content="INDEX,FOLLOW" />
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="msapplication-TileImage" content="{{ asset('assets/img/logo.png') }}" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
  <meta property="og:image" content="{{ asset('assets/img/logo.png') }}" />
  <meta name="theme-color" content="#ffffff" />
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Serif+Display:ital,wght@0,100..900;1,100..900&amp;family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/room-grid-component.css') }}" />
  <style>
    * {
      font-family: "Cinzel", sans-serif;
    }

    .gallery-row .col-md-6 {
      padding: 0px 3px;
      margin: 0px;
      margin-bottom: 6px;
    }

    .row.gy-4 .col-lg-6 {
      padding: 0px 3px;
      margin-top: 6px;
      aspect-ratio: 16/9;

      div div img {
        object-fit: cover;
      }
    }

    @media (max-width: 768px) {
      .row.gy-4 .col-lg-6 {
        aspect-ratio: 1/1;
      }
    }
  </style>
</head>

<body>
  <div class="slider-drag-cursor">
    <i class="fal fa-arrows-up-down-left-right"></i>
  </div>

  @include('partials.public-header')

  @yield('content')

  @include('partials.public-footer')

  <!--scroll to top-->
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="
            transition: stroke-dashoffset 10ms linear 0s;
            stroke-dasharray: 307.919, 307.919;
            stroke-dashoffset: 307.919;
          "></path>
    </svg>
  </div>
  <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
