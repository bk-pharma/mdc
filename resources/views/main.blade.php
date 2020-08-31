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

  <!--dataTables CDN -->
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

  <!--Select bootstrap css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.2/css/scroller.dataTables.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ">
      <li class="nav-item ml-auto">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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

          <li class="nav-item">

            @if(Request::is('import'))
              <a href="{{ url('/import') }}" class="nav-link active">
            @else
              <a href="{{ url('/import') }}" class="nav-link ">
            @endif
              <i class="nav-icon fas fa-file-upload"></i>
                <p>
                  Import
                </p>
              </a>
          </li>

          <li class="nav-item">
            @if(Request::is('sanitation'))
              <a href="{{ url('/sanitation') }}" class="nav-link active">
            @else
              <a href="{{ url('/sanitation') }}" class="nav-link ">
            @endif
              <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Sanitation
                </p>
              </a>

          </li>


            <li class="nav-item">

              @if(Request::is('manual'))
                <a href="#" class="nav-link active">
              @else
                <a href="{{ url('/manual') }}" class="nav-link ">
              @endif
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                  <p>
                    Manual Sanitation
                  </p>
                </a>
              </li>


              <li class="nav-item">

                @if(Request::is('unclean'))
                  <a href="#" class="nav-link active">
                @else
                  <a href="{{ url('/unclean') }}" class="nav-link ">
                @endif
                  <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>
                      Uncleaned Data
                    </p>
                  </a>
                </li>

          <li class="nav-item">

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
    @yield('import')
    @yield('sanitation')
    @yield('uncleanedData')
    @yield('manualSanitation')

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
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <!--Select bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
  {{-- Scroller --}}
  <script src="https://cdn.datatables.net/scroller/2.0.2/js/dataTables.scroller.min.js"></script>

  @stack('import-scripts')
  @stack('sanitation-scripts')
  @stack('manualSanitation-scripts')
  @stack('uncleanedData-scripts')
</body>
</html>
