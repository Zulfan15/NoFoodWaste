@extends('layouts.admin.master')

@section('title', 'Pengaturan Pengguna')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/settings-simple.css') }}">
@endsection

@section('content')
<div class="container-fluid settings-container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title"><i class="fa fa-cogs me-2"></i>Pengaturan Pengguna</h4>
                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                </div>
                <div class="card-body">
                    <!-- Tab Navigation yang Disederhanakan -->
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="true">
                                <i class="fa fa-bell me-2"></i>Notifikasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">
                                <i class="fa fa-user me-2"></i>Akun
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">
                                <i class="fa fa-lock me-2"></i>Privasi
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="settingsTabContent">                        <!-- === TAB NOTIFIKASI === -->
                        <div class="tab-pane fade show active" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-bell me-2"></i>Pengaturan Notifikasi
                            </h5>
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <form id="settingsForm" action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="settings_type" value="notifications">
                                
                                <!-- Row dengan Cards -->
                                <div class="row">
                                    <!-- CARD 1: Pengaturan Notifikasi Utama -->
                                    <div class="col-md-6 mb-4">
                                        <div class="settings-card">
                                            <div class="settings-card-header">
                                                <i class="fa fa-envelope me-2 text-primary"></i>
                                                <span>Pengaturan Notifikasi Utama</span>
                                            </div>
                                            <div class="settings-card-body">
                                                <!-- Opsi 1: Email Notifications -->
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="emailNotifications" name="emailNotifications" value="1" {{ old('emailNotifications', $user->email_notifications ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="emailNotifications">
                                                            Notifikasi Email
                                                        </label>
                                                    </div>
                                                    <div class="form-text">Terima notifikasi melalui email</div>
                                                </div>
                                                
                                                <!-- Opsi 2: Donation Alerts -->
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="donationAlerts" name="donationAlerts" value="1" {{ old('donationAlerts', $user->donation_alerts ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="donationAlerts">
                                                            Pemberitahuan Donasi Baru
                                                        </label>
                                                    </div>
                                                    <div class="form-text">Dapatkan pemberitahuan saat donasi tersedia di sekitar Anda</div>
                                                </div>
                                                
                                                <!-- Opsi 3: Claim Updates -->
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="claimUpdates" name="claimUpdates" value="1" {{ old('claimUpdates', $user->claim_updates ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="claimUpdates">
                                                            Update Status Klaim
                                                        </label>
                                                    </div>
                                                    <div class="form-text">Dapatkan pemberitahuan saat status klaim berubah</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- CARD 2: Frekuensi Notifikasi -->
                                    <div class="col-md-6 mb-4">
                                        <div class="settings-card">
                                            <div class="settings-card-header">
                                                <i class="fa fa-clock-o me-2 text-warning"></i>
                                                <span>Frekuensi Notifikasi</span>
                                            </div>
                                            <div class="settings-card-body">
                                                <div class="mb-3">
                                                    <label class="form-label mb-3">Pilih frekuensi menerima notifikasi:</label>
                                                    <div class="frequency-options">
                                                        <div class="form-check frequency-option-card">
                                                            <input class="form-check-input" type="radio" name="notificationFrequency" id="freqImmediate" value="immediate" {{ old('notificationFrequency', $user->notification_frequency ?? 'immediate') == 'immediate' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="freqImmediate">
                                                                <i class="fa fa-bolt text-danger"></i>
                                                                <span>Segera</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check frequency-option-card">
                                                            <input class="form-check-input" type="radio" name="notificationFrequency" id="freqDaily" value="daily" {{ old('notificationFrequency', $user->notification_frequency ?? 'immediate') == 'daily' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="freqDaily">
                                                                <i class="fa fa-calendar-o text-primary"></i>
                                                                <span>Harian</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check frequency-option-card">
                                                            <input class="form-check-input" type="radio" name="notificationFrequency" id="freqWeekly" value="weekly" {{ old('notificationFrequency', $user->notification_frequency ?? 'immediate') == 'weekly' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="freqWeekly">
                                                                <i class="fa fa-calendar text-success"></i>
                                                                <span>Mingguan</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-4">
                                        <button type="button" id="toggleAdvanced" class="btn btn-outline-secondary btn-sm">
                                            <i class="fa fa-cog me-2"></i>Tampilkan Pengaturan Lanjutan
                                        </button>
                                    </div>
                                    
                                    <!-- Bagian Pengaturan Lanjutan (disembunyikan secara default) -->
                                    <div id="advancedSettings" class="row">
                                        <!-- CARD 3: Komunikasi Pesan -->
                                        <div class="col-md-6 mb-4">
                                            <div class="settings-card">
                                                <div class="settings-card-header">
                                                    <i class="fa fa-comments me-2 text-info"></i>
                                                    <span>Komunikasi Pesan</span>
                                                </div>
                                                <div class="settings-card-body">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="directMessages" name="directMessages" value="1" {{ old('directMessages', $user->direct_messages ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="directMessages">
                                                            Terima Pesan Langsung
                                                        </label>
                                                    </div>
                                                    <div class="form-text">Terima pesan dari pengguna lain dan tim NoFoodWaste</div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- CARD 4: Notifikasi Platform -->
                                        <div class="col-md-6 mb-4">
                                            <div class="settings-card">
                                                <div class="settings-card-header">
                                                    <i class="fa fa-desktop me-2 text-success"></i>
                                                    <span>Notifikasi Platform</span>
                                                </div>
                                                <div class="settings-card-body">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="systemNotifications" name="systemNotifications" value="1" {{ old('systemNotifications', $user->system_notifications ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="systemNotifications">
                                                            Aktifkan Notifikasi Platform
                                                        </label>
                                                    </div>
                                                    <div class="form-text">Terima notifikasi melalui sistem notifikasi platform NoFoodWaste</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 text-end mt-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save me-2"></i>Simpan Pengaturan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                          <!-- === TAB AKUN === -->
                        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-user me-2"></i>Pengaturan Akun
                            </h5>
                            
                            <div class="row">
                                <!-- CARD 1: Informasi Profil -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-id-card me-2 text-primary"></i>
                                            <span>Informasi Profil</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <form action="#">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="name" value="{{ $user->name }}">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                                    <input type="text" class="form-control" id="phone" value="{{ $user->phone }}">
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD 2: Keamanan Akun -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-shield me-2 text-success"></i>
                                            <span>Keamanan Akun</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <form action="#">
                                                <div class="mb-3">
                                                    <label for="currentPassword" class="form-label">Password Saat Ini</label>
                                                    <input type="password" class="form-control" id="currentPassword">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="newPassword" class="form-label">Password Baru</label>
                                                    <input type="password" class="form-control" id="newPassword">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                                                    <input type="password" class="form-control" id="confirmPassword">
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Ubah Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD 3: Preferensi Akun -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-sliders me-2 text-warning"></i>
                                            <span>Preferensi Akun</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Bahasa</label>
                                                <select class="form-select">
                                                    <option value="id" selected>Bahasa Indonesia</option>
                                                    <option value="en">English</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="darkMode" checked>
                                                    <label class="form-check-label" for="darkMode">
                                                        Mode Gelap
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Simpan Preferensi</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD 4: Informasi Lokasi -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-map-marker me-2 text-danger"></i>
                                            <span>Informasi Lokasi</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="address" rows="2">{{ $user->address ?? 'Jl. Contoh No. 123, Jakarta' }}</textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="city" class="form-label">Kota</label>
                                                <input type="text" class="form-control" id="city" value="{{ $user->city ?? 'Jakarta' }}">
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="shareLocation" checked>
                                                <label class="form-check-label" for="shareLocation">
                                                    Bagikan Lokasi untuk Donasi Terdekat
                                                </label>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <!-- === TAB PRIVASI === -->
                        <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-lock me-2"></i>Pengaturan Privasi
                            </h5>
                            
                            <div class="row">
                                <!-- CARD 1: Visibilitas Profil -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-eye me-2 text-primary"></i>
                                            <span>Visibilitas Profil</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="profileVisibility" id="visibilityPublic" value="public" {{ $user->profile_visibility == 'public' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="visibilityPublic">
                                                    Publik
                                                </label>
                                                <div class="form-text">Semua orang dapat melihat profil Anda</div>
                                            </div>
                                            
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="profileVisibility" id="visibilityContacts" value="contacts" {{ $user->profile_visibility == 'contacts' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="visibilityContacts">
                                                    Hanya kontak
                                                </label>
                                                <div class="form-text">Hanya pengguna yang terhubung dengan Anda yang dapat melihat profil</div>
                                            </div>
                                            
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="profileVisibility" id="visibilityPrivate" value="private" {{ $user->profile_visibility == 'private' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="visibilityPrivate">
                                                    Privat
                                                </label>
                                                <div class="form-text">Tidak ada yang dapat melihat profil Anda</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD 2: Keamanan Data -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-shield me-2 text-success"></i>
                                            <span>Keamanan Data</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="dataEncryption" checked>
                                                <label class="form-check-label" for="dataEncryption">
                                                    Enkripsi Data
                                                </label>
                                                <div class="form-text">Semua data Anda akan dienkripsi untuk keamanan lebih</div>
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                                <label class="form-check-label" for="twoFactorAuth">
                                                    Autentikasi Dua Faktor
                                                </label>
                                                <div class="form-text">Aktifkan verifikasi tambahan saat login</div>
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="activityLog" checked>
                                                <label class="form-check-label" for="activityLog">
                                                    Log Aktivitas
                                                </label>
                                                <div class="form-text">Pantau aktivitas login dan perubahan akun</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD 3: Berbagi Data -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-share-alt me-2 text-warning"></i>
                                            <span>Berbagi Data</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="shareWithPartners">
                                                <label class="form-check-label" for="shareWithPartners">
                                                    Bagikan dengan Mitra
                                                </label>
                                                <div class="form-text">Izinkan mitra NoFoodWaste mengakses data Anda</div>
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="shareForResearch" checked>
                                                <label class="form-check-label" for="shareForResearch">
                                                    Bagikan untuk Riset
                                                </label>
                                                <div class="form-text">Izinkan penggunaan data anonim untuk penelitian</div>
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="shareStats" checked>
                                                <label class="form-check-label" for="shareStats">
                                                    Bagikan Statistik
                                                </label>
                                                <div class="form-text">Izinkan berbagi statistik donasi Anda</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD 4: Privasi Kontak -->
                                <div class="col-md-6 mb-4">
                                    <div class="settings-card">
                                        <div class="settings-card-header">
                                            <i class="fa fa-address-book me-2 text-danger"></i>
                                            <span>Privasi Kontak</span>
                                        </div>
                                        <div class="settings-card-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="showEmail">
                                                <label class="form-check-label" for="showEmail">
                                                    Tampilkan Email
                                                </label>
                                                <div class="form-text">Tampilkan email di profil publik Anda</div>
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="showPhone">
                                                <label class="form-check-label" for="showPhone">
                                                    Tampilkan Nomor Telepon
                                                </label>
                                                <div class="form-text">Tampilkan nomor telepon di profil publik Anda</div>
                                            </div>
                                            
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="showLocation" checked>
                                                <label class="form-check-label" for="showLocation">
                                                    Tampilkan Lokasi
                                                </label>
                                                <div class="form-text">Tampilkan kota Anda di profil publik</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 text-end mt-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save me-2"></i>Simpan Pengaturan Privasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/settings-simple.js') }}"></script>
@endsection
