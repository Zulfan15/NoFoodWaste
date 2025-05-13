<div class="page-main-header">  <div class="main-header-left d-flex align-items-center">
    <button class="toggle-sidebar me-3" aria-label="Toggle Sidebar" aria-expanded="false">
      <i class="status_toggle middle" data-feather="menu" id="sidebar-toggle"></i>
    </button>
    
    <!-- Dark Mode Toggle Button -->
    <button class="mode header-icon mx-3" aria-label="Toggle Dark Mode">
      <i data-feather="moon"></i>
    </button>
    
    <!-- Notification Button (moved from right to left) -->
    <div class="onhover-dropdown">
      <button class="notification-box header-icon mx-3" aria-label="Notifications" aria-expanded="false">
        <i data-feather="bell"></i>
        <span class="dot-animated" style="display:none;"></span>
        <span class="notification-count sr-only">0 new notifications</span>
      </button>
      <ul class="notification-dropdown onhover-show-div" role="menu" aria-label="Notifications List">
        <li class="notification-header">
          <div class="d-flex justify-content-between align-items-center">
            <p class="f-w-700 mb-0">Notifications</p>
            <span class="badge badge-primary badge-pill notification-badge">0</span>
          </div>
          <div class="notification-actions mt-2 mb-1">
            <button class="btn btn-sm btn-outline-primary mark-all-read" aria-label="Mark all as read">
              <i data-feather="check-circle" class="icon-xs"></i> Mark all as read
            </button>
            <a href="{{ route('notifications') }}" class="btn btn-sm btn-link ml-2" aria-label="View all notifications">
              <i data-feather="external-link" class="icon-xs"></i> View all
            </a>
          </div>
        </li>
        <li class="noti-loading" style="display:none; text-align:center; padding: 15px;">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="sr-only">Loading notifications...</span>
          </div>
        </li>
        <li class="notification-content" data-loaded="false">
          <!-- Notification items will be loaded here dynamically -->
          <div class="empty-state" style="display:none;">
            <div class="text-center p-3">
              <i data-feather="bell-off" class="mb-2"></i>
              <p>Tidak ada notifikasi baru</p>
            </div>
          </div>
          <div class="error-state" style="display:none;">
            <div class="text-center p-3">
              <i data-feather="alert-circle" class="mb-2 text-danger"></i>
              <p>Gagal memuat notifikasi</p>
              <button class="btn btn-outline-primary btn-sm retry-load mt-2">Coba Lagi</button>
            </div>
          </div>
        </li>
        <li class="notification-footer">
          <div class="text-center p-2">
            <small class="text-muted">Terakhir diperbarui: <span class="last-updated">Baru saja</span></small>
          </div>
        </li>
      </ul>
    </div>
  </div>
  
  <!-- Center Logo and Brand (moved from left) -->
  <div class="brand-logo text-center">
    <a href="{{ route('dashboard') }}" aria-label="Dashboard">
      <img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="NoFoodWaste Logo" style="height: 40px;">
    </a>
  </div>
    <div class="nav-right d-flex align-items-center">
    <div class="nav-icons">
      <!-- User Profile Section - Updated to match design -->
      <div class="dropdown profile-section ms-4">
        <button class="profile-toggle dropdown-toggle border-0 bg-transparent d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="user-info text-light me-2">
            <div class="user-name">{{ Auth::check() ? Auth::user()->username : 'User' }}</div>
            <div class="user-role">{{ Auth::check() ? ucfirst(Auth::user()->role) : 'Guest' }}</div>          </div>
          @if (Auth::check() && Auth::user()->profile_photo)
            <img class="profile-photo" src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="User Profile">
          @else
            <img class="profile-photo" src="{{ asset('assets/images/usericon.png') }}" alt="Default Avatar">
          @endif
        </button>
        @if(Auth::check())
        <ul class="profile-dropdown onhover-show-div" role="menu">
          <li>
            <a href="{{ route('profile') }}">
              <i data-feather="user"></i>
              <span>Profil</span>
            </a>
          </li>
          <li>
            <a href="{{ route('my-activity') }}">
              <i data-feather="activity"></i>
              <span>Aktivitas Saya</span>
            </a>
          </li>
          <li>
            <a href="{{ route('settings') }}">
              <i data-feather="settings"></i>
              <span>Pengaturan</span>
            </a>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
              @csrf
              <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
                <i data-feather="log-out"></i>
                <span>Keluar</span>
              </a>
            </form>
          </li>
        </ul>
        @else
        <ul class="profile-dropdown onhover-show-div" role="menu">
          <li>
            <a href="{{ route('login') }}">
              <i data-feather="log-in"></i>
              <span>Login</span>
            </a>
          </li>
          <li>
            <a href="{{ route('register') }}">
              <i data-feather="user-plus"></i>
              <span>Register</span>
            </a>
          </li>
        </ul>
        @endif
      </div>
    </div>
    <button class="d-lg-none mobile-toggle" aria-label="Toggle Mobile Menu" aria-expanded="false">
      <i data-feather="more-horizontal"></i>
    </button>
  </div>
</div>
