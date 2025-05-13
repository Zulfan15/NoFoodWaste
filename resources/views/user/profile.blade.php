@extends('layouts.admin.master')

@section('title', 'Profil Pengguna')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
<style>
    #preview-container {
        max-width: 300px;
        max-height: 300px;
        overflow: hidden;
        margin: 10px auto;
        display: none;
    }
    
    #preview-container img {
        width: 100%;
    }
    
    /* New improved styles for better layout */
    .profile-container {
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(36, 105, 92, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #24695c, #3a9188);
        color: #fff;
        padding: 30px 20px 100px;
        position: relative;
    }
    
    .profile-body {
        position: relative;
        margin-top: -70px;
        padding: 0 20px 20px;
    }      .profile-image-container {
        width: 100px;
        height: 100px;
        margin: 0 auto -20px;
        position: relative;
    }
      .profile-image-wrapper {
        width: 90px;
        height: 90px;
        position: relative;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }    .profile-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
        border-radius: 50%;
    }
      .profile-overlay-text {
        color: #fff;
        text-align: center;
        font-size: 12px;
    }
    
    .profile-overlay:hover {
        opacity: 1;
    }
      .social-icons a {
        display: inline-flex;
        width: 32px;
        height: 32px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 5px;
        font-size: 18px;
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .social-icons a.facebook {
        background-color: #3b5998;
    }
    
    .social-icons a.twitter {
        background-color: #1da1f2;
    }
    
    .social-icons a.instagram {
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    }
    
    .social-icons a.linkedin {
        background-color: #0077b5;
    }
      .user-meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .user-meta-item i {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(36, 105, 92, 0.1);
        color: #24695c;
        border-radius: 8px;
        margin-right: 10px;
    }
    
    .tab-content-box {
        background-color: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    }
    
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
        border-radius: 10px;
        padding: 12px 20px;
        margin-right: 5px;
    }
    
    .nav-pills .nav-link.active {
        background-color: #24695c;
        color: #fff;
    }
    
    .nav-pills .nav-link:not(.active):hover {
        background-color: rgba(36, 105, 92, 0.1);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 20px 0;
    }
      .stats-card {
        padding: 15px 10px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
    }
    
    .stats-number {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stats-title {
        font-size: 12px;
        color: rgba(0, 0, 0, 0.6);
    }
    
    .btn-custom-primary {
        background-color: #24695c;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn-custom-primary:hover {
        background-color: #1e594e;
        box-shadow: 0 5px 15px rgba(36, 105, 92, 0.2);
    }
      .stats-card.blue {
        background-color: rgba(0, 123, 255, 0.1);
        color: #0d6efd;
    }
    
    .stats-card.green {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .stats-card.purple {
        background-color: rgba(111, 66, 193, 0.1);
        color: #6f42c1;
    }
      .btn-custom-outline {
        color: #24695c;
        border: 1px solid #24695c;
        background-color: transparent;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn-custom-outline:hover {
        background-color: rgba(36, 105, 92, 0.1);
    }
    
    @media (max-width: 991px) {
        .profile-header {
            padding: 20px 15px 80px;
        }
        
        .profile-body {
            margin-top: -50px;
        }
          .profile-image-container {
            width: 100px;
            height: 100px;
        }
        
        .profile-image-wrapper {
            width: 70px;
            height: 70px;
        }
    }
    .password-strength {
        height: 5px;
        margin-bottom: 10px;
        background-color: #eee;
        border-radius: 2px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .password-strength.weak {
        width: 25%;
        background-color: #dc3545;
    }
    
    .password-strength.medium {
        width: 50%;
        background-color: #ffc107;
    }
    
    .password-strength.strong {
        width: 75%;
        background-color: #28a745;
    }
    
    .password-strength.very-strong {
        width: 100%;
        background-color: #198754;
    }

    .timeline-container {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline-container:before {
        content: '';
        position: absolute;
        height: 100%;
        width: 2px;
        left: 15px;
        top: 0;
        background-color: #e5e5e5;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    
    .timeline-dot {
        position: absolute;
        width: 30px;
        height: 30px;
        left: -40px;
        top: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        z-index: 2;
    }
    
    .timeline-content {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="row">
        <!-- Left Column - User Info -->
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-image-wrapper mb-3" id="profile-image-container">
                        @if ($user->profile_photo)                            <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" alt="User Avatar" id="current-profile-photo" class="img-fluid rounded-circle">
                        @else
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="User Avatar" id="current-profile-photo" class="img-fluid rounded-circle">
                        @endif                        <div class="profile-overlay" id="change-photo-trigger">
                            <div class="profile-overlay-text">
                                <i class="fa fa-camera"></i> <span class="d-none d-sm-inline">Ubah</span>
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="mb-0">{{ $user->username }}</h4>
                    <p class="text-muted">{{ ucfirst($user->role) }}</p>
                    
                    <div class="social-icons mt-3">
                        @if($user->facebook_url)
                            <a href="{{ $user->facebook_url }}" target="_blank" class="facebook" title="Facebook"><i class="fa fa-facebook-square"></i></a>
                        @endif
                        
                        @if($user->twitter_url)
                            <a href="{{ $user->twitter_url }}" target="_blank" class="twitter" title="Twitter"><i class="fa fa-twitter-square"></i></a>
                        @endif
                        
                        @if($user->instagram_url)
                            <a href="{{ $user->instagram_url }}" target="_blank" class="instagram" title="Instagram"><i class="fa fa-instagram"></i></a>
                        @endif
                        
                        @if($user->linkedin_url)
                            <a href="{{ $user->linkedin_url }}" target="_blank" class="linkedin" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="text-start">
                        <div class="mb-3">
                            <p class="mb-1"><i class="fa fa-envelope text-primary me-2"></i> {{ $user->email }}</p>
                            @if($user->phone_number)
                                <p class="mb-1"><i class="fa fa-phone text-primary me-2"></i> {{ $user->phone_number }}</p>
                            @endif
                            @if($user->address)
                                <p class="mb-1"><i class="fa fa-map-marker text-primary me-2"></i> {{ $user->address }}</p>
                            @endif
                        </div>
                        
                        @if($user->bio)
                            <div class="mb-3">
                                <h6 class="mb-2">Bio</h6>
                                <p class="text-muted">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>
                      <hr>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-card blue">
                                <div class="stats-number">{{ $stats['total_donations'] }}</div>
                                <div class="stats-title">Total Donasi</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card green">
                                <div class="stats-number">{{ $stats['total_claims'] }}</div>
                                <div class="stats-title">Total Klaim</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card purple">
                                <div class="stats-number">{{ $stats['available_donations'] }}</div>
                                <div class="stats-title">Donasi Tersedia</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card orange">
                                <div class="stats-number">{{ $stats['completed_claims'] }}</div>
                                <div class="stats-title">Klaim Selesai</div>
                            </div>
                        </div>
                    </div>
                      <div class="btn-group w-100 mt-3">
                        <a href="{{ route('donations.my') }}" class="btn btn-outline-primary">Donasi Saya</a>
                        <a href="{{ route('my-activity') }}" class="btn btn-outline-primary">Aktivitas</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Edit Forms -->
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                                <i class="fa fa-user me-1"></i> Profil
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">
                                <i class="fa fa-lock me-1"></i> Keamanan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                                <i class="fa fa-share-alt me-1"></i> Media Sosial
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">
                                <i class="fa fa-history me-1"></i> Aktivitas
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content py-4" id="profileTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" placeholder="Nama Pengguna">
                                            <label for="username">Nama Pengguna</label>
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="Email" readonly>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Nomor Telepon">
                                            <label for="phone_number">Nomor Telepon</label>
                                            @error('phone_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="role" value="{{ ucfirst($user->role) }}" placeholder="Role" readonly>
                                            <label for="role">Role</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Alamat" style="height: 100px">{{ old('address', $user->address) }}</textarea>
                                            <label for="address">Alamat</label>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" placeholder="Bio" style="height: 100px">{{ old('bio', $user->bio ?? '') }}</textarea>
                                            <label for="bio">Bio</label>
                                            @error('bio')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                            <form action="{{ route('profile.update-password') }}" method="POST" id="passwordForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Password Saat Ini">
                                            <label for="current_password">Password Saat Ini</label>
                                            @error('current_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-1">
                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Password Baru">
                                            <label for="new_password">Password Baru</label>
                                            @error('new_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="password-strength"></div>
                                        <div class="password-feedback text-muted"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi Password">
                                            <label for="new_password_confirmation">Konfirmasi Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-lock me-1"></i> Ubah Password
                                    </button>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <div class="card bg-light border-0 mt-4">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">Deaktivasi Akun</h5>
                                    <p class="card-text">Deaktivasi akun akan menonaktifkan akun Anda secara sementara. Anda dapat mengaktifkannya kembali kapan saja.</p>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                        <i class="fa fa-power-off me-1"></i> Deaktivasi Akun
                                    </button>
                                </div>
                            </div>
                            
                            <div class="card bg-light border-0 mt-4">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">Hapus Akun</h5>
                                    <p class="card-text">Menghapus akun akan menghapus semua data Anda secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fa fa-trash me-1"></i> Hapus Akun
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media Tab -->
                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $user->facebook_url) }}" placeholder="Facebook URL">
                                            <label for="facebook_url"><i class="fa fa-facebook-square text-primary me-1"></i> Facebook URL</label>
                                            @error('facebook_url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $user->twitter_url) }}" placeholder="Twitter URL">
                                            <label for="twitter_url"><i class="fa fa-twitter-square text-info me-1"></i> Twitter URL</label>
                                            @error('twitter_url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url) }}" placeholder="Instagram URL">
                                            <label for="instagram_url"><i class="fa fa-instagram text-danger me-1"></i> Instagram URL</label>
                                            @error('instagram_url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="LinkedIn URL">
                                            <label for="linkedin_url"><i class="fa fa-linkedin-square text-primary me-1"></i> LinkedIn URL</label>
                                            @error('linkedin_url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save me-1"></i> Simpan Media Sosial
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Activity Tab -->
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <h5 class="mb-4">Aktivitas Terbaru</h5>
                            
                            @if(isset($recentActivities) && $recentActivities->count() > 0)
                                <div class="timeline-container">
                                    @foreach($recentActivities as $activity)
                                        <div class="timeline-item">
                                            <div class="timeline-dot {{ $activity['type'] == 'donation' ? 'bg-primary' : 'bg-success' }}">
                                                <i class="fa {{ $activity['type'] == 'donation' ? 'fa-gift' : 'fa-hand-paper-o' }}"></i>
                                            </div>
                                            <div class="timeline-content card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                                        <span class="badge {{ $activity['status'] == 'available' ? 'bg-success' : ($activity['status'] == 'claimed' ? 'bg-primary' : ($activity['status'] == 'expired' ? 'bg-danger' : 'bg-warning')) }}">
                                                            {{ ucfirst($activity['status']) }}
                                                        </span>
                                                    </div>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fa fa-calendar-o me-1"></i> {{ $activity['date']->diffForHumans() }}
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="badge bg-light text-dark">{{ ucfirst($activity['type']) }}</span>
                                                    </p>
                                                    <a href="{{ $activity['url'] }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="text-center mt-4">
                                    <a href="{{ route('my-activity') }}" class="btn btn-primary">
                                        <i class="fa fa-list-alt me-1"></i> Lihat Semua Aktivitas
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle me-2"></i> Belum ada aktivitas terbaru.
                                </div>
                                
                                <div class="text-center mt-4">
                                    <a href="{{ route('donate') }}" class="btn btn-primary">
                                        <i class="fa fa-plus-circle me-1"></i> Buat Donasi Baru
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Form (Hidden) -->
<form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" id="photoUploadForm" class="d-none">
    @csrf
    <input type="file" name="profile_photo" id="profilePhotoInput" class="d-none" accept="image/*">
</form>

<!-- Preview Modal -->
<div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-labelledby="photoPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoPreviewModalLabel">Pratinjau Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="preview-container">
                    <img id="photo-preview" src="#" alt="Preview">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="savePhotoBtn">Simpan Foto</button>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deactivateModalLabel">Deaktivasi Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.deactivate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Tindakan ini akan menonaktifkan akun Anda sementara. Anda masih dapat login kembali untuk mengaktifkan akun kapan saja.</p>
                    <div class="mb-3">
                        <label for="deactivate-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="deactivate-password" name="password" required>
                        <div class="form-text">Masukkan password Anda untuk konfirmasi.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Deaktivasi Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle me-2"></i> Peringatan: Tindakan ini akan menghapus akun Anda secara permanen dan tidak dapat dikembalikan.
                    </div>
                    <div class="mb-3">
                        <label for="delete-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="delete-password" name="password" required>
                        <div class="form-text">Masukkan password Anda untuk konfirmasi.</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="confirm_delete" name="confirm_delete" required>
                        <label class="form-check-label" for="confirm_delete">Saya mengerti bahwa tindakan ini tidak dapat dibatalkan dan ingin menghapus akun saya secara permanen.</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun Permanen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track if any tab was specified in URL
        const handleTabFromUrl = () => {
            const url = document.location.toString();
            if (url.match('#')) {
                const tabId = url.split('#')[1];
                const tabElement = document.querySelector(`#profileTabs button[data-bs-target="#${tabId}"]`);
                if (tabElement) {
                    new bootstrap.Tab(tabElement).show();
                }
            }
        };
        
        // Set tab ID in URL when tab changes
        const setTabInUrl = (tab) => {
            const targetId = tab.getAttribute('data-bs-target').substring(1);
            history.replaceState(null, null, `#${targetId}`);
        };
        
        // Initialize tabs
        const initTabs = () => {
            const tabLinks = document.querySelectorAll('#profileTabs button');
            tabLinks.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                    setTabInUrl(e.target);
                });
            });
            handleTabFromUrl();
        };
        
        // Profile photo upload handling
        const initPhotoUpload = () => {
            const profileImageContainer = document.getElementById('profile-image-container');
            const changePhotoTrigger = document.getElementById('change-photo-trigger');
            const fileInput = document.getElementById('profilePhotoInput');
            const uploadForm = document.getElementById('photoUploadForm');
            const previewContainer = document.getElementById('preview-container');
            const photoPreview = document.getElementById('photo-preview');
            const savePhotoBtn = document.getElementById('savePhotoBtn');
            const photoPreviewModal = new bootstrap.Modal(document.getElementById('photoPreviewModal'));
            
            if (changePhotoTrigger && fileInput && uploadForm) {
                changePhotoTrigger.addEventListener('click', function() {
                    fileInput.click();
                });
                
                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length > 0) {
                        // Show preview
                        const file = fileInput.files[0];
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            photoPreview.src = e.target.result;
                            previewContainer.style.display = 'block';
                            photoPreviewModal.show();
                        }
                        
                        reader.readAsDataURL(file);
                    }
                });
                
                savePhotoBtn.addEventListener('click', function() {
                    uploadForm.submit();
                    photoPreviewModal.hide();
                });
            }
        };
        
        // Password strength indicator
        const initPasswordStrength = () => {
            const newPasswordInput = document.getElementById('new_password');
            const passwordStrength = document.querySelector('.password-strength');
            const passwordFeedback = document.querySelector('.password-feedback');
            
            if (newPasswordInput && passwordStrength && passwordFeedback) {
                newPasswordInput.addEventListener('input', function() {
                    const password = newPasswordInput.value;
                    let strength = 0;
                    let feedback = '';
                    
                    // Clear classes
                    passwordStrength.className = 'password-strength';
                    
                    if (password.length === 0) {
                        passwordStrength.style.width = '0%';
                        passwordFeedback.textContent = '';
                        return;
                    }
                    
                    // Check password strength
                    if (password.length >= 8) strength += 1;
                    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
                    if (password.match(/\d+/)) strength += 1;
                    if (password.match(/[!@#$%^&*(),.?":{}|<>]/)) strength += 1;
                    
                    // Update UI based on strength
                    switch (strength) {
                        case 1:
                            passwordStrength.classList.add('weak');
                            feedback = 'Lemah: Tambahkan kombinasi huruf besar, kecil, angka, dan simbol';
                            break;
                        case 2:
                            passwordStrength.classList.add('medium');
                            feedback = 'Sedang: Tambahkan lebih banyak karakter dan variasi';
                            break;
                        case 3:
                            passwordStrength.classList.add('strong');
                            feedback = 'Kuat: Password sudah baik';
                            break;
                        case 4:
                            passwordStrength.classList.add('very-strong');
                            feedback = 'Sangat Kuat: Password sempurna!';
                            break;
                    }
                    
                    passwordFeedback.textContent = feedback;
                });
            }
        };
        
        // Password confirmation validation
        const initPasswordValidation = () => {
            const passwordForm = document.getElementById('passwordForm');
            const newPasswordInput = document.getElementById('new_password');
            const passwordConfirm = document.getElementById('new_password_confirmation');
            
            if (passwordForm && newPasswordInput && passwordConfirm) {
                passwordForm.addEventListener('submit', function(e) {
                    if (newPasswordInput.value !== passwordConfirm.value) {
                        e.preventDefault();
                        alert('Password konfirmasi tidak cocok!');
                    }
                });
            }
        };
        
        // Initialize all components
        initTabs();
        initPhotoUpload();
        initPasswordStrength();
        initPasswordValidation();
        
        // Add animation to statistics
        const animateStats = () => {
            const statsNumbers = document.querySelectorAll('.stats-number');
            statsNumbers.forEach((statElement, index) => {
                const finalValue = parseInt(statElement.innerText);
                statElement.innerText = '0';
                
                setTimeout(() => {
                    let currentValue = 0;
                    const increment = Math.max(1, Math.floor(finalValue / 20));
                    const interval = setInterval(() => {
                        currentValue += increment;
                        if (currentValue > finalValue) {
                            currentValue = finalValue;
                            clearInterval(interval);
                        }
                        statElement.innerText = currentValue;
                    }, 30);
                }, index * 100);
            });
        };
        
        // Run stats animation
        animateStats();
    });
</script>
@endsection
