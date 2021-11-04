<?php use App\Http\Controllers\PinjamLabController; ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/BL3.png" rel="icon" type="image/png">
    <link href="{{ asset('argon') }}/vendor/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('argon') }}/css/icofont.min.css">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css?v={{time()}}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v={{time()}}" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/stef.css?v={{time()}}" rel="stylesheet">


    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    

</head>

<body class="{{ $class ?? '' }}">

    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.navbars.sidebar')
    @endauth

    <div class="main-content">
        @include('layouts.navbars.navbar')
        <!--Dashboard-->

        <div>
   
            <div class="card bg-secondary shadow">
                @yield('content')

                @auth()
                @include('layouts.footers.auth')
                @endauth
                @guest()
                @include('layouts.footers.guest')
                @endguest
            </div>


        </div>
    </div>

    </div>



    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('argon') }}/vendor/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('argon') }}/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript" src="{{ asset('argon') }}/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    @stack('js')

    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   
</body>

</html>