<div class="page-main-header" style="background-color: #2C6B2F;">
  <div class="main-header-right row m-0">
    <div class="main-header-left">
      <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="" style="height:50px;"></a></div>
      <div class="dark-logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="" style="height:50px;"></a></div>
      <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle" style="color: #FAF3E0;"></i></div> 
    </div>
    <div class="left-menu-header col">
      <ul>
        <li>
          <h5 style="color: #FFFFFF;">No Food Waste</h5>
        </li>
      </ul>
    </div>
    <div class="nav-right col pull-right right-menu p-0">
      <ul class="nav-menus">
        <li><a class="text-white" href="#!" onclick="javascript:toggleFullScreen()" style="color: #FAF3E0; font-size: 20px;"><i data-feather="maximize" style="color: #FAF3E0;"></i></a></li> 
        <li>
          <div class="mode"><i class="fa fa-moon-o" style="color: #FAF3E0;"></i></div> 
        </li>        <li class="onhover-dropdown">
          <div class="notification-box"><i data-feather="bell" style="color: #FAF3E0;"></i><span class="dot-animated" style="background-color: #FAF3E0;"></span></div>
          <ul class="notification-dropdown onhover-show-div">
            <li>
              <p class="f-w-700 mb-0">You have 3 Notifications<span class="pull-right badge badge-primary badge-pill">4</span></p>
            </li>
            <li class="noti-primary">
              <div class="media">
                <span class="notification-bg bg-light-primary"><i data-feather="activity" style="color: #FAF3E0;"> </i></span>
                <div class="media-body">
                  <p>Delivery processing </p>
                  <span>10 minutes ago</span>
                </div>
              </div>
            </li>
            <li class="noti-secondary">
              <div class="media">
                <span class="notification-bg bg-light-secondary"><i data-feather="check-circle" style="color: #FAF3E0;"> </i></span>
                <div class="media-body">
                  <p>Order Complete</p>
                  <span>1 hour ago</span>
                </div>
              </div>
            </li>
            <li class="noti-success">
              <div class="media">
                <span class="notification-bg bg-light-success"><i data-feather="file-text" style="color: #FAF3E0;"> </i></span>
                <div class="media-body">
                  <p>Tickets Generated</p>
                  <span>3 hour ago</span>
                </div>
              </div>
            </li>
            <li class="noti-danger">
              <div class="media">
                <span class="notification-bg bg-light-danger"><i data-feather="user-check" style="color: #FAF3E0;"> </i></span>
                <div class="media-body">
                  <p>Delivery Complete</p>
                  <span>6 hour ago</span>
                </div>
              </div>
            </li>
          </ul>
        </li>
        
        <li class="onhover-dropdown p-0">          <div class="media profile-media">
            @if (Auth::check() && Auth::user()->profile_photo)
              <img class="b-r-10" src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="" width="35" height="35" style="object-fit: cover;">
            @else
              <img class="b-r-10" src="{{ asset('assets/images/user/avatar.jpg') }}" alt="" width="35" height="35">
            @endif
            <div class="media-body">
              <span>{{ Auth::check() ? Auth::user()->username : 'Pengguna' }}</span>
              <p class="mb-0 font-roboto">{{ Auth::check() ? ucfirst(Auth::user()->role) : 'Guest' }} <i class="middle fa fa-angle-down"></i></p>
            </div>          </div>
          @if(Auth::check())
          <ul class="profile-dropdown onhover-show-div">
            <li><a href="{{ route('profile') }}"><i data-feather="user"></i><span>Profil </span></a></li>
            <li><a href="{{ route('my-activity') }}"><i data-feather="activity"></i><span>Aktivitas Saya</span></a></li>
            <li><a href="{{ route('settings') }}"><i data-feather="settings"></i><span>Pengaturan</span></a></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();"><i data-feather="log-out"></i><span>Keluar</span></a>
              </form>
            </li>
          </ul>
          @else
          <ul class="profile-dropdown onhover-show-div">
            <li><a href="{{ route('login') }}"><i data-feather="log-in"></i><span>Login</span></a></li>
            <li><a href="{{ route('register') }}"><i data-feather="user-plus"></i><span>Register</span></a></li>
          </ul>
          @endif
        </li>
      </ul>
    </div>
    <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal" style="color: #FAF3E0;"></i></div> <!-- Ganti warna mobile toggle -->
  </div>
</div>
