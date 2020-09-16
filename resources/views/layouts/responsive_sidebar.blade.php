<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ URL::asset('images/BK LOGO.png') }}" class="img-circle" alt="Avatar">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->auth_fullname }}</p>
                <a href=""><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ url('/import') }}">
                    <i class="fa fa-dashboard"></i> <span>Import</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Sanitation</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ url('/sanitation') }}">
                            <i class="fa fa-cogs"></i> Automated
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/mdc/manual/sanitation') }}">
                            <i class="fa fa-book"></i> Manual
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>