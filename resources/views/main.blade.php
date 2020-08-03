<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MDC</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ">
      <li class="nav-item ml-auto">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
<!--       <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel d-flex">
        <div class="info">
          @if (!Auth::check())
          <h5 class="text-white">Juan Dela Cruz</h5>
          @else
          <h5 class="text-white">
          {{ Auth::user()->auth_fullname }} </h5>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @if(Request::is('sanitation/*'))
            <li class="nav-item has-treeview menu-open">
          @else
            <li class="nav-item has-treeview">
          @endif
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Sanitation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                @if(Request::is('sanitation/phase-one')):
                  <a href="#" class="nav-link active">
                @else
                  <a href="{{ url('/sanitation/phase-one') }}" class="nav-link">
                @endif
                  <i class="far fas fa-angle-right nav-icon"></i>
                  <p>Phase 1</p>
                </a>
              </li>
              <li class="nav-item">
                @if(Request::is('sanitation/phase-two'))
                  <a href="#" class="nav-link active">
                @else
                  <a href="{{ url('/sanitation/phase-two') }}" class="nav-link">
                @endif
                  <i class="far fas fa-angle-right nav-icon"></i>
                  <p>Phase 2</p>
                </a>
              </li>
              <li class="nav-item">
                @if(Request::is('sanitation/phase-three'))
                  <a href="#" class="nav-link active">
                @else
                  <a href="{{ url('/sanitation/phase-three') }}" class="nav-link">
                @endif
                  <i class="far fas fa-angle-right nav-icon"></i>
                  <p>Phase 3</p>
                </a>
              </li>
              <li class="nav-item">
                @if(Request::is('sanitation/phase-four'))
                  <a href="#" class="nav-link active">
                @else
                  <a href="{{ url('/sanitation/phase-four') }}" class="nav-link">
                @endif
                  <i class="far fas fa-angle-right nav-icon"></i>
                  <p>Phase 4</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">

          @if(Request::is('rules'))
            <a href="#" class="nav-link active">
          @else
            <a href="{{ url('/rules') }}" class="nav-link">
          @endif
            <i class="nav-icon fab fa-rev"></i>
              <p>
                Rules
              </p>
            </a>
          </li>

          <li class="nav-item">

          @if(Request::is('name-formatter'))
            <a href="#" class="nav-link active">
          @else
            <a href="{{ url('/name-formatter') }}" class="nav-link">
          @endif
            <i class="nav-icon far fa-keyboard"></i>
              <p>
                Name Formatter
              </p>
            </a>
          </li>

          @if (!Auth::check())
          <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-in-alt"></i>
              <p>
                Sign In
              </p>
            </a>
          </li>

          @else
          <li class="nav-item">
            <a  href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Sign Out
            </p>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </a>
          @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    @yield('sanitationPhaseOne')
    @yield('sanitationPhaseTwo')
    @yield('sanitationPhaseThree')
    @yield('sanitationPhaseFour')
    @yield('rules')
    @yield('nameFormatter')
  </div>

</div>
<!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  {{-- <script src="{{asset('dist/js/pages/dashboard.js')}}"></script> --}}

  @stack('sanitationPhaseOne-scripts')
  @stack('sanitationPhaseTwo-scripts')
  @stack('sanitationPhaseThree-scripts')
  @stack('sanitationPhaseFour-scripts')
  @stack('rules-scripts')
  @stack('nameFormatter-scripts')
</body>
</html>
