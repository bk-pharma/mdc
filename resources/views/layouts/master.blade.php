<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | MDC</title>
    
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="icon" href="{{ URL::asset('images/BK LOGO.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/skin.css') }}">
   	
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
   	
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/iziToast.min.css') }}">
    @yield('header_scripts')

</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    
    <div class="wrapper">

        @include('layouts.navigation')

        @include('layouts.responsive_sidebar')

        @yield('content')

		{{-- <footer class="main-footer">
		    <div class="pull-right hidden-xs">
		      v1
		    </div>
		    Copyright © {{ date('Y') }} Bell Kenz Pharma Inc. All rights
		    reserved.
		</footer> --}}

    </div>

    <!-- jQuery 3 -->
    <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
   
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('assets/js/adminlte.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/iziToast.min.js') }}" type="text/javascript"></script>
   
    @yield('footer_scripts')
    @stack('import-scripts')
    @stack('sanitation-scripts')

</body>

</html>