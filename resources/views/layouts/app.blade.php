<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@extends('layouts/header')
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav ">
          <li class="nav-item ml-auto">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

         <!-- Right Side Of Navbar -->
         <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->

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
      <div class="user-panel mt-2 d-flex align-item-center">
        <div class="info">
          <h5 class="text-white">Juan Dela Cruz</h5>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="fas fa-tachometer-alt"></i>
              <p>
                Sanitation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="http://localhost/mdc/public/dashboard" class="nav-link">
                  <i class="far fa-circle"></i>
                  <p>Phase 1 </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="http://localhost/mdc/public/dashboard1" class="nav-link">
                  <i class="far fa-circle"></i>
                  <p>Phase 2 </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle"></i>
                  <p>Phase 3 </p>
                </a>
              </li>
            </ul>
          </li>
            @guest
            <li class="nav-item">
                <a  class="nav-link" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i>
                <p>
                  Login
                </p>
                </a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                        <p>
                          Register
                        </p>
                    </a>
                </li>
            @endif
        @else
        <li class="nav-item">
            <a  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="nav-link">
                   <i class="fas fa-sign-out-alt"></i>
                   <p>
                    Logout
                  </p>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </a>
          </li>
        @endguest
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
  </div>

</div>
<!-- ./wrapper -->
@extends('layouts/footer')
</body>
</html>