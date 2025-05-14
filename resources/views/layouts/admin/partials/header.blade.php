<div class="page-main-header">  <div class="main-header-left d-flex align-items-center">
    <button class="toggle-sidebar me-3" aria-label="Toggle Sidebar" aria-expanded="false">
      <i class="status_toggle middle" data-feather="menu" id="sidebar-toggle"></i>
    </button>
      <!-- Dark Mode Toggle Button -->
    <button class="mode header-icon mx-3" aria-label="Toggle Dark Mode">
      <i data-feather="moon"></i>
    </button>
      <!-- Notification Button -->
    <div class="onhover-dropdown notification-dropdown-wrapper">
      <button class="notification-box header-icon mx-3" aria-label="Notifikasi" aria-expanded="false">
        <i data-feather="bell"></i>
        <span class="badge rounded-pill badge-primary notification-counter" style="position: absolute; top: -5px; right: -5px; font-size: 10px; display: none;">0</span>
      </button>
      <div class="notification-dropdown onhover-show-div" role="menu" aria-label="Daftar Notifikasi">
        <div class="notification-header px-3 py-2 border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 f-w-600">Notifikasi</h6>
            <span class="badge rounded-pill bg-primary notification-badge">0</span>
          </div>
        </div>
          <div class="notification-actions px-3 py-2 border-bottom d-flex justify-content-between">
          <a href="{{ route('notifications', ['mark_as_read' => 'true']) }}" class="text-primary d-flex align-items-center">
            <i class="icon-xs me-1" data-feather="check-circle"></i> Tandai semua dibaca
          </a>
          <a href="{{ route('notifications') }}" class="text-primary d-flex align-items-center">
            <span>Lihat semua</span> <i class="icon-xs ms-1" data-feather="external-link"></i>
          </a>
        </div>
        
        <div class="notification-loading text-center p-3" style="display: none;">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Loading notifications...</span>
          </div>
        </div>
        
        <div class="notification-content" data-loaded="false" style="max-height: 300px; overflow-y: auto;">
          <!-- Notification items will be loaded here dynamically -->
          <div class="empty-state p-4 text-center">
            <i data-feather="bell-off" style="height: 40px; width: 40px; color: #ccc; margin-bottom: 10px;"></i>
            <p class="mb-0">Tidak ada notifikasi baru</p>
          </div>
          
          <div class="error-state p-4 text-center" style="display:none;">
            <i data-feather="alert-circle" style="height: 40px; width: 40px; color: #dc3545; margin-bottom: 10px;"></i>
            <p class="mb-2">Gagal memuat notifikasi</p>
            <button class="btn btn-outline-primary btn-sm retry-load">Coba Lagi</button>
          </div>
        </div>
        
        <div class="notification-footer text-center p-2 border-top">
          <small class="text-muted">Terakhir diperbarui: <span class="last-updated">Baru saja</span></small>
        </div>
      </div>
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
