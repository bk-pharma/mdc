<header class="main-header">
	<style>
		a svg {
			position: absolute;
    		left: -10px;
		}
	</style>
	<span class="logo">
      	BK
    </span>
    <nav class="navbar navbar-static-top">
      	<!-- Sidebar toggle button-->
      	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	<span class="sr-only">Toggle navigation</span>
      	</a>

      	<div class="navbar-custom-menu">
	        <ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				
		        <li class="dropdown user user-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class="hidden-xs mt-5">{!! Avatar::create(Auth::user()->auth_fullname)
						->setBackground(Auth::user()->tag_color)
						->setDimension(20,20)
						->setfontSize(12)
						->toSvg() !!} </span>
		              	<span class="hidden-xs">{{ Auth::user()->auth_fullname }}</span>
					</a>
					
		            <ul class="dropdown-menu">
			            <!-- Avatar -->
			            <li class="user-header">
			                <img src="{{ URL::asset('images/BK LOGO.png') }}" class="img-circle" alt="Avatar">
			                <p>
			                  	{{ Auth::user()->auth_fullname }}
			                </p>
			            </li>
		              
		              	<!-- Menu Footer-->
			            <li class="user-footer">
			                <div class="pull-left">
			                  	<a href="#" class="btn btn-default btn-flat">Dashboard</a>
			                </div>
			                <div class="pull-right">
								<a  href="{{ route('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
								<p>
								Log Out
								</p>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</a>
			                </div>
			            </li>
		            </ul>
		        </li>
	        </ul>
      	</div>
    </nav>
</header>