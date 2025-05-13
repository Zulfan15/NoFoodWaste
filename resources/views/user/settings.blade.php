@extends('layouts.admin.master')

@section('title', 'Pengaturan Pengguna')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
@endsection

@section('content')
<!-- Skip to content link for keyboard accessibility -->
<a href="#settingsTabContent" class="skip-to-content">Skip to content</a>

<!-- Theme toggle button in the header -->
<div class="theme-switcher ms-2">
    <button class="btn btn-sm btn-outline-light" id="themeSwitcher" title="Toggle Dark Mode">
        <i class="fa fa-moon-o"></i>
    </button>
    <div class="dropdown d-inline-block ms-1">
        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="colorThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Change Color Theme">
            <i class="fa fa-palette"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="colorThemeDropdown">
            <li><a class="dropdown-item" href="#" data-theme="default">Default Theme</a></li>
            <li><a class="dropdown-item" href="#" data-theme="blue">Blue Theme</a></li>
            <li><a class="dropdown-item" href="#" data-theme="purple">Purple Theme</a></li>
        </ul>
    </div>
    <button class="btn btn-sm btn-outline-light ms-1" id="highContrastToggle" title="High Contrast Mode">
        <i class="fa fa-adjust"></i>
    </button>
</div>

<div class="container-fluid settings-container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title"><i class="fa fa-cogs me-2"></i>Pengaturan Pengguna</h4>
                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                </div>
                <div class="card-body">                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="true">
                                <i class="fa fa-bell me-2"></i>Notifikasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">
                                <i class="fa fa-lock me-2"></i>Privasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">
                                <i class="fa fa-user me-2"></i>Akun
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false">
                                <i class="fa fa-database me-2"></i>Data
                            </button>
                        </li>
                    </ul>                    <div class="tab-content p-3" id="settingsTabContent">
                        <!-- Notifications Settings -->
                        <div class="tab-pane fade show active" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-bell me-2"></i>Pengaturan Notifikasi
                                <span class="settings-help" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Kelola bagaimana dan kapan Anda menerima pemberitahuan dari sistem.">
                                    <i class="fa fa-question-circle"></i>
                                </span>
                            </h5>
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <div class="alert alert-info mt-3 mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fa fa-info-circle fa-2x text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading">Tip untuk Pengaturan Optimal</h6>
                                        <p class="mb-0">Mengelola preferensi notifikasi membantu Anda mendapatkan informasi yang tepat tentang donasi makanan. Anda dapat mengubah pengaturan ini kapan saja.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-section">
                                <form action="{{ route('settings.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="settings_type" value="notifications">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications" name="emailNotifications" value="1" {{ old('emailNotifications', $user->email_notifications ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="emailNotifications">
                                                <i class="fa fa-envelope text-primary me-2"></i>Notifikasi Email
                                            </label>
                                        </div>
                                        <div class="form-text">Terima notifikasi melalui email untuk kabar terbaru</div>
                                    </div>                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="donationAlerts" name="donationAlerts" value="1" {{ old('donationAlerts', $user->donation_alerts ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="donationAlerts">
                                                <i class="fa fa-gift text-success me-2"></i>Pemberitahuan Donasi Baru
                                            </label>
                                        </div>
                                        <div class="form-text">Dapatkan pemberitahuan ketika donasi baru tersedia di sekitar Anda</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="claimUpdates" name="claimUpdates" value="1" {{ old('claimUpdates', $user->claim_updates ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="claimUpdates">
                                                <i class="fa fa-check-circle text-info me-2"></i>Update Status Klaim
                                            </label>
                                        </div>
                                        <div class="form-text">Dapatkan pemberitahuan ketika status klaim Anda berubah</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="newsUpdates" name="newsUpdates" value="1" {{ old('newsUpdates', $user->news_updates ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="newsUpdates">
                                                <i class="fa fa-newspaper-o text-warning me-2"></i>Berita & Update
                                            </label>
                                        </div>
                                        <div class="form-text">Dapatkan berita terbaru tentang program dan fitur NoFoodWaste</div>
                                    </div>
                                    <div class="notification-type-card mt-4">
                                        <div class="notification-type-title">
                                            <div class="notification-type-icon">
                                                <i class="fa fa-desktop"></i>
                                            </div>
                                            Notifikasi Platform
                                            <span class="badge-recommended">BARU</span>
                                        </div>
                                        <p class="small text-muted">Terima notifikasi melalui sistem notifikasi platform NoFoodWaste</p>
                                        
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="systemNotifications" name="systemNotifications" value="1" {{ old('systemNotifications', $user->system_notifications ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="systemNotifications">
                                                <i class="fa fa-bell text-primary me-2"></i>Aktifkan Notifikasi Platform
                                            </label>
                                        </div>
                                        
                                        <div class="notification-frequency mt-3" id="frequencyOptions">
                                            <p class="small text-muted mb-2">Frekuensi Pengiriman:</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="notificationFrequency" id="freqImmediate" value="immediate" {{ old('notificationFrequency', $user->notification_frequency ?? 'immediate') == 'immediate' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="freqImmediate">Segera</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="notificationFrequency" id="freqDaily" value="daily" {{ old('notificationFrequency', $user->notification_frequency ?? 'immediate') == 'daily' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="freqDaily">Harian</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="notificationFrequency" id="freqWeekly" value="weekly" {{ old('notificationFrequency', $user->notification_frequency ?? 'immediate') == 'weekly' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="freqWeekly">Mingguan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Settings cards untuk pengaturan komunikasi -->
                                    <div class="mb-4">
                                        <h6 class="mb-3"><i class="fa fa-comment text-primary me-2"></i>Preferensi Komunikasi</h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="settings-card">
                                                    <div class="settings-card-title">
                                                        <i class="fa fa-bell text-warning me-2"></i>Pemberitahuan Sistem
                                                    </div>
                                                    <p class="settings-card-text">Pilih bagaimana Anda ingin menerima notifikasi penting dari platform</p>
                                                    <div class="form-check form-switch mt-3">
                                                        <input class="form-check-input" type="checkbox" id="inAppNotifications" name="inAppNotifications" value="1" {{ old('inAppNotifications', $user->in_app_notifications ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inAppNotifications">
                                                            Notifikasi dalam Aplikasi
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="settings-card">
                                                    <div class="settings-card-title">
                                                        <i class="fa fa-comments text-info me-2"></i>Komunikasi Pesan
                                                    </div>
                                                    <p class="settings-card-text">Atur preferensi pesan dari pengguna lain dan tim NoFoodWaste</p>
                                                    <div class="form-check form-switch mt-3">
                                                        <input class="form-check-input" type="checkbox" id="directMessages" name="directMessages" value="1" {{ old('directMessages', $user->direct_messages ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="directMessages">
                                                            Terima Pesan Langsung
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pengaturan Preferensi Jarak Donasi -->
                                    <div class="mb-4 mt-4">
                                        <h6 class="mb-3"><i class="fa fa-map-marker text-danger me-2"></i>Preferensi Jarak Donasi</h6>
                                        <p class="text-muted small mb-3">Sesuaikan jarak maksimum untuk notifikasi donasi yang ingin Anda terima</p>
                                        
                                        <div class="mb-3">
                                            <label for="donationRadius" class="form-label">Radius Notifikasi Donasi (km)</label>
                                            <div class="d-flex align-items-center">
                                                <input type="range" class="form-range me-3" min="1" max="50" step="1" id="donationRadius" name="donationRadius" value="{{ old('donationRadius', $user->donation_radius ?? 10) }}">
                                                <span class="donation-radius-value badge bg-primary">{{ old('donationRadius', $user->donation_radius ?? 10) }} km</span>
                                            </div>
                                            <div class="form-text">Donasi dalam radius ini akan muncul di notifikasi Anda</div>
                                        </div>
                                        
                                        <div class="form-check form-switch mt-3">
                                            <input class="form-check-input" type="checkbox" id="priorityNotifications" name="priorityNotifications" value="1" {{ old('priorityNotifications', $user->priority_notifications ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="priorityNotifications">
                                                <i class="fa fa-star text-warning me-2"></i>Notifikasi Prioritas untuk Makanan Segera Kadaluarsa
                                            </label>
                                        </div>
                                        <div class="form-text">Terima notifikasi prioritas untuk makanan yang akan segera kadaluarsa (dalam 24 jam)</div>
                                    </div>
                                    <!-- Preferensi Kategori Donasi -->
                                    <div class="mb-4 mt-4">
                                        <h6 class="mb-3"><i class="fa fa-tags text-primary me-2"></i>Preferensi Kategori Donasi</h6>
                                        <p class="text-muted small mb-3">Pilih kategori donasi yang ingin Anda prioritaskan dalam notifikasi</p>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="catMakanan" name="donationCategories[]" value="food" {{ in_array('food', old('donationCategories', $user->donation_categories ?? ['food'])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catMakanan">
                                                        <i class="fa fa-cutlery text-success me-2"></i>Makanan
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="catMinuman" name="donationCategories[]" value="beverage" {{ in_array('beverage', old('donationCategories', $user->donation_categories ?? ['beverage'])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catMinuman">
                                                        <i class="fa fa-coffee text-warning me-2"></i>Minuman
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="catBuah" name="donationCategories[]" value="fruit" {{ in_array('fruit', old('donationCategories', $user->donation_categories ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catBuah">
                                                        <i class="fa fa-apple text-danger me-2"></i>Buah-buahan
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="catSayur" name="donationCategories[]" value="vegetable" {{ in_array('vegetable', old('donationCategories', $user->donation_categories ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catSayur">
                                                        <i class="fa fa-leaf text-success me-2"></i>Sayuran
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="catMakananPokok" name="donationCategories[]" value="staple" {{ in_array('staple', old('donationCategories', $user->donation_categories ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catMakananPokok">
                                                        <i class="fa fa-shopping-basket text-primary me-2"></i>Makanan Pokok
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="catLainnya" name="donationCategories[]" value="other" {{ in_array('other', old('donationCategories', $user->donation_categories ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="catLainnya">
                                                        <i class="fa fa-ellipsis-h text-secondary me-2"></i>Lainnya
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <div class="settings-card">
                                            <div class="d-flex align-items-start">
                                                <div class="notification-type-icon">
                                                    <i class="fa fa-map"></i>
                                                </div>
                                                <div>
                                                    <div class="settings-card-title">Peta Donasi Terdekat</div>
                                                    <p class="settings-card-text">Tampilan visual donasi di sekitar lokasi Anda untuk memudahkan pencarian.</p>
                                                    <div class="form-check form-switch mt-3">
                                                        <input class="form-check-input" type="checkbox" id="enableDonationMap" name="enableDonationMap" value="1" {{ old('enableDonationMap', $user->enable_donation_map ?? true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="enableDonationMap">
                                                            Aktifkan Peta Donasi
                                                            <span class="badge-feature">FITUR BARU</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-completion mb-4">
                                        <div class="settings-progress">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="progress-title">Kelengkapan Pengaturan</span>
                                                <span class="badge bg-primary rounded-pill">{{ $settingsCompletion ?? 75 }}%</span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $settingsCompletion ?? 75 }}%;" aria-valuenow="{{ $settingsCompletion ?? 75 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress-label mt-1">Lengkapi pengaturan untuk meningkatkan pengalaman Anda</div>
                                            
                                            <div class="settings-tips mt-3">
                                                <div class="tips-list small">
                                                    @if(!($user->two_factor_auth ?? false))
                                                        <div class="tip-item"><i class="fa fa-exclamation-circle text-warning me-1"></i> Aktifkan autentikasi dua faktor untuk keamanan lebih baik</div>
                                                    @endif
                                                    @if(!($user->profile_visibility ?? true))
                                                        <div class="tip-item"><i class="fa fa-info-circle text-info me-1"></i> Profil publik memudahkan kolaborasi dengan donatur lain</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save me-2"></i>Simpan Preferensi Notifikasi
                                            </button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#shareSettingsModal">
                                                <i class="fa fa-share-alt me-1"></i>Bagikan Preferensi
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="resetNotificationSettings">
                                                <i class="fa fa-refresh me-1"></i>Reset ke Default
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                        <!-- Privacy Settings -->
                        <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-lock me-2"></i>Pengaturan Privasi
                                <span class="settings-help" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Atur bagaimana data pribadi Anda digunakan dan siapa yang dapat melihatnya.">
                                    <i class="fa fa-question-circle"></i>
                                </span>
                            </h5>
                            
                            <div class="data-security-info">
                                <p><i class="fa fa-shield text-primary me-2"></i><strong>Informasi Keamanan Data</strong></p>
                                <p>NoFoodWaste berkomitmen untuk melindungi data pribadi Anda. Pengaturan privasi ini membantu Anda mengontrol bagaimana data Anda digunakan dalam platform.</p>
                            </div>
                            
                            <div class="settings-section">
                                <form action="{{ route('settings.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="settings_type" value="privacy">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="profileVisibility" name="profileVisibility" value="1" {{ old('profileVisibility', $user->profile_visibility ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="profileVisibility">
                                                <i class="fa fa-eye text-primary me-2"></i>Profil Publik
                                                <span class="info-badge" data-bs-toggle="tooltip" title="Memungkinkan pengguna lain melihat detail profil publik Anda">i</span>
                                            </label>
                                        </div>
                                        <div class="form-text">Izinkan pengguna lain melihat profil Anda untuk memudahkan kolaborasi donasi</div>
                                    </div>                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="locationSharing" name="locationSharing" value="1" {{ old('locationSharing', $user->location_sharing ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="locationSharing">
                                                <i class="fa fa-map-marker text-danger me-2"></i>Bagikan Lokasi
                                                <span class="info-badge" data-bs-toggle="tooltip" title="Memungkinkan menampilkan lokasi Anda secara umum untuk donasi">i</span>
                                            </label>
                                        </div>
                                        <div class="form-text">Tampilkan lokasi Anda (dalam radius) untuk memudahkan proses donasi dan pengambilan</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="activityTracking" name="activityTracking" value="1" {{ old('activityTracking', $user->activity_tracking ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="activityTracking">
                                                <i class="fa fa-chart-line text-info me-2"></i>Lacak Aktivitas
                                                <span class="info-badge" data-bs-toggle="tooltip" title="Memungkinkan sistem melacak aktivitas untuk personalisasi">i</span>
                                            </label>
                                        </div>
                                        <div class="form-text">Izinkan sistem melacak aktivitas Anda untuk pengalaman yang lebih personal</div>
                                    </div>
                                    <div class="mb3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="cookieConsent" name="cookieConsent" value="1" {{ old('cookieConsent', $user->cookie_consent ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cookieConsent">
                                                <i class="fa fa-cookie-bite text-warning me-2"></i>Izinkan Cookie
                                                <span class="info-badge" data-bs-toggle="tooltip" title="Mengizinkan penggunaan cookie untuk pengalaman lebih baik">i</span>
                                            </label>
                                        </div>
                                        <div class="form-text">Izinkan penggunaan cookie untuk meningkatkan pengalaman pengguna</div>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save me-2"></i>Simpan Pengaturan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>                        <!-- Account Settings -->
                        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-user me-2"></i>Pengaturan Akun
                                <span class="settings-help" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Ubah pengaturan dasar akun pengguna Anda.">
                                    <i class="fa fa-question-circle"></i>
                                </span>
                            </h5>
                            
                            <div class="settings-section">
                                <form action="{{ route('settings.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="settings_type" value="account">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="language" class="form-label">
                                                <i class="fa fa-language text-primary me-2"></i>Bahasa
                                            </label>
                                            <select class="form-select" id="language" name="language">
                                                <option value="id" {{ old('language', $user->language ?? 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                                <option value="en" {{ old('language', $user->language ?? 'id') == 'en' ? 'selected' : '' }}>English</option>
                                            </select>
                                            <div class="form-text">Pilih bahasa tampilan untuk aplikasi</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="timezone" class="form-label">
                                                <i class="fa fa-clock-o text-primary me-2"></i>Zona Waktu
                                            </label>
                                            <select class="form-select" id="timezone" name="timezone">
                                                <option value="Asia/Jakarta" {{ old('timezone', $user->timezone ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (GMT+7)</option>
                                                <option value="Asia/Makassar" {{ old('timezone', $user->timezone ?? 'Asia/Jakarta') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (GMT+8)</option>
                                                <option value="Asia/Jayapura" {{ old('timezone', $user->timezone ?? 'Asia/Jakarta') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (GMT+9)</option>
                                            </select>
                                            <div class="form-text">Pilih zona waktu sesuai lokasi Anda</div>
                                        </div>
                                    </div>                                    <div class="mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="twoFactorAuth" name="twoFactorAuth" value="1" {{ old('twoFactorAuth', $user->two_factor_auth ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="twoFactorAuth">
                                                <i class="fa fa-shield text-success me-2"></i>Autentikasi Dua Faktor
                                                <span class="badge bg-success" style="font-size: 0.7rem;">DIREKOMENDASIKAN</span>
                                            </label>
                                        </div>
                                        <div class="form-text">Aktifkan autentikasi dua faktor untuk meningkatkan keamanan akun Anda</div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="loginAlerts" name="loginAlerts" value="1" {{ old('loginAlerts', $user->login_alerts ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="loginAlerts">
                                                <i class="fa fa-bell text-warning me-2"></i>Notifikasi Login Baru
                                            </label>
                                        </div>
                                        <div class="form-text">Terima notifikasi email ketika ada aktivitas login baru di akun Anda</div>
                                    </div>
                                    
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save me-2"></i>Simpan Pengaturan
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="account-danger-zone mt-4">
                                <h5 class="text-danger"><i class="fa fa-exclamation-triangle me-2"></i>Zona Berbahaya</h5>
                                <p>Tindakan di bawah ini dapat berdampak permanen pada akun Anda</p>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <button type="button" class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                            <i class="fa fa-user-times me-2"></i>Nonaktifkan Akun
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fa fa-trash me-2"></i>Hapus Akun
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>                        <!-- Data Settings -->
                        <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                            <h5 class="settings-section-title">
                                <i class="fa fa-database me-2"></i>Pengaturan Data
                                <span class="settings-help" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Kelola data pribadi Anda dan cara pengelolaannya.">
                                    <i class="fa fa-question-circle"></i>
                                </span>
                            </h5>
                            
                            <div class="data-security-info">
                                <p><i class="fa fa-info-circle text-primary me-2"></i><strong>Tentang Data Anda</strong></p>
                                <p>Kami memberikan kontrol penuh atas data pribadi Anda. Dari halaman ini, Anda dapat mengunduh salinan data Anda atau meminta penghapusan data.</p>
                                <ul>
                                    <li>Data pribadi: Informasi profil, preferensi, dan pengaturan Anda</li>
                                    <li>Riwayat aktivitas: Donasi, klaim, dan interaksi lainnya</li>
                                    <li>Statistik: Ringkasan aktivitas donasi dan klaim Anda</li>
                                </ul>
                            </div>
                            
                            <div class="settings-section">
                                <h6 class="mb-3"><i class="fa fa-download text-primary me-2"></i>Ekspor Data</h6>
                                <p>Unduh salinan data Anda dalam format yang mudah dibaca.</p>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card border-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title"><i class="fa fa-user me-2"></i>Data Profil</h6>
                                                <p class="card-text small">Informasi profil, preferensi, dan pengaturan Anda</p>
                                                <a href="{{ route('profile.export-data', ['type' => 'profile']) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-download me-1"></i>Unduh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-light mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title"><i class="fa fa-history me-2"></i>Riwayat Aktivitas</h6>
                                                <p class="card-text small">Donasi, klaim, dan interaksi Anda di platform</p>
                                                <a href="{{ route('profile.export-data', ['type' => 'activity']) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-download me-1"></i>Unduh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <h6 class="mb-3"><i class="fa fa-eraser text-danger me-2"></i>Hapus Data</h6>
                                <p>Meminta penghapusan data Anda dari platform kami.</p>
                                
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle me-2"></i>Perhatian: Tindakan ini hanya menghapus data tertentu dan tidak menghapus akun Anda.
                                </div>
                                
                                <form action="{{ route('profile.data-deletion-request') }}" method="POST" class="mb-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="deletionType" class="form-label">Jenis Penghapusan</label>
                                        <select class="form-select" id="deletionType" name="deletion_type" required>
                                            <option value="">Pilih jenis data yang ingin dihapus</option>
                                            <option value="activity">Riwayat aktivitas</option>
                                            <option value="location">Data lokasi</option>
                                            <option value="messages">Pesan dan komunikasi</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deletionReason" class="form-label">Alasan</label>
                                        <textarea class="form-control" id="deletionReason" name="deletion_reason" rows="3" placeholder="Jelaskan alasan Anda meminta penghapusan data"></textarea>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="deletionConfirm" name="deletion_confirm" required>
                                        <label class="form-check-label" for="deletionConfirm">
                                            Saya memahami bahwa tindakan ini tidak dapat dibatalkan
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-paper-plane me-2"></i>Kirim Permintaan
                                    </button>
                                </form>
                            </div>
                            <div class="data-export-section mb-4 mt-5">
                                        <h6 class="mb-3"><i class="fa fa-download text-primary me-2"></i>Ekspor Data Pribadi</h6>
                                        <p class="text-muted small mb-3">Unduh data profil dan aktivitas Anda dalam format JSON atau CSV</p>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="settings-card">
                                                    <div class="settings-card-title">
                                                        <i class="fa fa-user-circle text-primary me-2"></i>Data Profil
                                                    </div>
                                                    <p class="settings-card-text">Ekspor data profil Anda termasuk informasi kontak dan preferensi pengaturan</p>
                                                    <div class="btn-group mt-3" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="exportProfileJson">
                                                            <i class="fa fa-file-code-o me-1"></i>JSON
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="exportProfileCsv">
                                                            <i class="fa fa-file-text-o me-1"></i>CSV
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="settings-card">
                                                    <div class="settings-card-title">
                                                        <i class="fa fa-history text-info me-2"></i>Riwayat Aktivitas
                                                    </div>
                                                    <p class="settings-card-text">Ekspor riwayat donasi dan klaim Anda pada platform NoFoodWaste</p>
                                                    <div class="btn-group mt-3" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-info" id="exportActivityJson">
                                                            <i class="fa fa-file-code-o me-1"></i>JSON
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-info" id="exportActivityCsv">
                                                            <i class="fa fa-file-text-o me-1"></i>CSV
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-info mt-3 mb-0">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="fa fa-info-circle fa-2x text-info"></i>
                                                </div>
                                                <div>
                                                    <h6 class="alert-heading">Tentang Ekspor Data</h6>
                                                    <p class="mb-0">Data Anda akan diproses dan diunduh ke perangkat Anda. Proses ini mungkin memerlukan waktu beberapa saat tergantung pada jumlah data yang Anda miliki.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    <div class="settings-version">
                        NoFoodWaste Settings v2.3.1 &copy; 2025 
                        <span class="d-inline-block ms-1" data-bs-toggle="tooltip" title="Last updated: May 13, 2025">
                            <i class="fa fa-info-circle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.deactivate') }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="deactivateModalLabel"><i class="fa fa-user-times me-2"></i>Nonaktifkan Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle me-2"></i>Tindakan ini akan menonaktifkan akun Anda sementara.
                    </div>
                    
                    <p>Apakah Anda yakin ingin menonaktifkan akun Anda? Tindakan ini akan:</p>
                    <ul>
                        <li>Menghentikan akses Anda ke platform</li>
                        <li>Menyembunyikan profil Anda dari pengguna lain</li>
                        <li>Menyimpan data Anda untuk diaktifkan kembali nanti</li>
                    </ul>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('deactivate_password') is-invalid @enderror" id="deactivatePassword" name="password" placeholder="Password">
                        <label for="deactivatePassword">Konfirmasi dengan password Anda</label>
                        @error('deactivate_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-2"></i>Batalkan
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-user-times me-2"></i>Nonaktifkan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fa fa-trash me-2"></i>Hapus Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i><strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <p>Apakah Anda yakin ingin menghapus akun Anda secara permanen? Semua data Anda akan dihapus dan tidak dapat dipulihkan, termasuk:</p>
                    <ul>
                        <li>Profil dan informasi pribadi</li>
                        <li>Riwayat donasi dan klaim</li>
                        <li>Data preferensi dan pengaturan</li>
                    </ul>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('delete_password') is-invalid @enderror" id="deletePassword" name="password" placeholder="Password">
                        <label for="deletePassword">Konfirmasi dengan password Anda</label>
                        @error('delete_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input @error('confirm_delete') is-invalid @enderror" type="checkbox" id="deleteConfirm" name="confirm_delete">
                        <label class="form-check-label" for="deleteConfirm">
                            Saya mengerti bahwa tindakan ini permanen dan tidak dapat dibatalkan
                        </label>
                        @error('confirm_delete')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-2"></i>Batalkan
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash me-2"></i>Hapus Akun Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Berbagi Preferensi -->
<div class="modal fade" id="shareSettingsModal" tabindex="-1" aria-labelledby="shareSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #24695c; color: white;">
                <h5 class="modal-title" id="shareSettingsModalLabel"><i class="fa fa-share-alt me-2"></i>Bagikan Preferensi Notifikasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda dapat berbagi preferensi notifikasi Anda dengan pengguna lain. Mereka dapat menggunakan pengaturan yang sama untuk memudahkan komunikasi.</p>
                
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>Berbagi preferensi tidak termasuk informasi pribadi. Hanya pengaturan notifikasi yang akan dibagikan.
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="shareSettingsLink" value="{{ route('settings') }}?share={{ base64_encode(json_encode([
                        'email_notifications' => $user->email_notifications,
                        'donation_alerts' => $user->donation_alerts,
                        'donation_radius' => $user->donation_radius,
                        'donation_categories' => $user->donation_categories
                    ])) }}" readonly>
                    <label for="shareSettingsLink">Link untuk Dibagikan</label>
                </div>
                
                <div class="d-grid">
                    <button type="button" class="btn btn-primary" id="copySettingsLink">
                        <i class="fa fa-copy me-2"></i>Salin Link
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aktifkan semua popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                trigger: 'hover focus',
                html: true
            })
        });
        
        // Aktifkan semua tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            })
        });
        
        // Restore tab active state from URL hash
        let url = document.location.toString();
        if (url.match('#')) {
            let tab = url.split('#')[1];
            if (tab) {
                $('.nav-tabs button[data-bs-target="#' + tab + '"]').tab('show');
            }
        }
        
        // Change hash for tab
        $('.nav-tabs button').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.getAttribute('data-bs-target').substr(1);
        });
        
        // Toggle frekuensi notifikasi berdasarkan status checkbox
        const systemNotificationsCheckbox = document.getElementById('systemNotifications');
        const frequencyOptions = document.getElementById('frequencyOptions');
        
        function toggleFrequencyOptions() {
            if (systemNotificationsCheckbox && frequencyOptions) {
                if (systemNotificationsCheckbox.checked) {
                    frequencyOptions.classList.remove('d-none');
                } else {
                    frequencyOptions.classList.add('d-none');
                }
            }
        }
        
        // Set initial state
        if (systemNotificationsCheckbox && frequencyOptions) {
            toggleFrequencyOptions();
            systemNotificationsCheckbox.addEventListener('change', toggleFrequencyOptions);
        }
        
        // Update radius value display
        const donationRadiusSlider = document.getElementById('donationRadius');
        const donationRadiusValue = document.querySelector('.donation-radius-value');
        
        if (donationRadiusSlider && donationRadiusValue) {
            donationRadiusSlider.addEventListener('input', function() {
                donationRadiusValue.textContent = this.value + ' km';
            });
        }
        
        // Konfirmasi untuk tombol simpan pengaturan
        const settingsForms = document.querySelectorAll('.settings-section form');
        settingsForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
                
                // Reset tombol setelah 2 detik (simulasi loading)
                setTimeout(function() {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            });
        });
        
        // Toggle konfirmasi untuk seluruh form-check elements
        const formCheckInputs = document.querySelectorAll('.form-check-input');
        formCheckInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    this.closest('.form-check').classList.add('text-success');
                } else {
                    this.closest('.form-check').classList.remove('text-success');
                }
            });
            
            // Set initial state
            if (input.checked) {
                input.closest('.form-check').classList.add('text-success');
            }
        });
        
        // Handler untuk tombol copy settings link
        const copySettingsLinkBtn = document.getElementById('copySettingsLink');
        const shareSettingsLink = document.getElementById('shareSettingsLink');
        
        if (copySettingsLinkBtn && shareSettingsLink) {
            copySettingsLinkBtn.addEventListener('click', function() {
                shareSettingsLink.select();
                document.execCommand('copy');
                
                // Change button text temporarily
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fa fa-check me-2"></i>Link Disalin!';
                this.classList.remove('btn-primary');
                this.classList.add('btn-success');
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                }, 2000);
            });
        }
        
        // Handler untuk tombol reset settings
        const resetNotificationSettingsBtn = document.getElementById('resetNotificationSettings');
        
        if (resetNotificationSettingsBtn) {
            resetNotificationSettingsBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin mengatur ulang semua preferensi notifikasi ke pengaturan default?')) {
                    // Reset all checkboxes to their default values
                    document.getElementById('emailNotifications').checked = true;
                    document.getElementById('donationAlerts').checked = true;
                    document.getElementById('claimUpdates').checked = true;
                    document.getElementById('newsUpdates').checked = false;
                    
                    if (document.getElementById('systemNotifications')) {
                        document.getElementById('systemNotifications').checked = true;
                    }
                    
                    if (document.getElementById('inAppNotifications')) {
                        document.getElementById('inAppNotifications').checked = true;
                    }
                    
                    if (document.getElementById('directMessages')) {
                        document.getElementById('directMessages').checked = true;
                    }
                    
                    if (document.getElementById('priorityNotifications')) {
                        document.getElementById('priorityNotifications').checked = false;
                    }
                    
                    if (document.getElementById('donationRadius')) {
                        document.getElementById('donationRadius').value = 10;
                        document.querySelector('.donation-radius-value').textContent = '10 km';
                    }
                    
                    // Reset category checkboxes
                    document.getElementById('catMakanan').checked = true;
                    document.getElementById('catMinuman').checked = true;
                    document.getElementById('catBuah').checked = false;
                    document.getElementById('catSayur').checked = false;
                    document.getElementById('catMakananPokok').checked = false;
                    document.getElementById('catLainnya').checked = false;
                    
                    // Update all form-check styling
                    formCheckInputs.forEach(input => {
                        if (input.checked) {
                            input.closest('.form-check').classList.add('text-success');
                        } else {
                            input.closest('.form-check').classList.remove('text-success');
                        }
                    });
                    
                    // Show success message
                    const toastContainer = document.createElement('div');
                    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                    toastContainer.style.zIndex = '11';
                    
                    toastContainer.innerHTML = `
                        <div class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa fa-refresh me-2"></i>Pengaturan berhasil diatur ulang ke default
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(toastContainer);
                    const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), {
                        delay: 3000
                    });
                    toast.show();
                }
            });
        }
        
        // Tampilkan konfirmasi setelah simpan pengaturan jika ada parameter success
        if (new URLSearchParams(window.location.search).has('success')) {
            const toastContainer = document.createElement('div');
            toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '11';
            
            toastContainer.innerHTML = `
                <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa fa-check-circle me-2"></i>Pengaturan berhasil disimpan
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toastContainer);
            const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), {
                delay: 3000
            });
            toast.show();
        }

        // Dark mode toggle functionality
        const themeSwitcher = document.getElementById('themeSwitcher');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        const currentTheme = localStorage.getItem('theme');
        
        // Set initial theme based on user preference or system setting
        if (currentTheme === 'dark' || (!currentTheme && prefersDarkScheme.matches)) {
            document.body.classList.add('dark-mode');
            if (themeSwitcher) {
                themeSwitcher.innerHTML = '<i class="fa fa-sun-o"></i>';
                themeSwitcher.setAttribute('title', 'Switch to Light Mode');
            }
        }
        
        // Toggle dark/light mode
        if (themeSwitcher) {
            themeSwitcher.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                let theme = 'light';
                
                if (document.body.classList.contains('dark-mode')) {
                    theme = 'dark';
                    this.innerHTML = '<i class="fa fa-sun-o"></i>';
                    this.setAttribute('title', 'Switch to Light Mode');
                } else {
                    this.innerHTML = '<i class="fa fa-moon-o"></i>';
                    this.setAttribute('title', 'Switch to Dark Mode');
                }
                
                localStorage.setItem('theme', theme);
            });
        }
        
        // Color theme switcher
        const themeButtons = document.querySelectorAll('[data-theme]');
        const settingsContainer = document.querySelector('.settings-container');
        const currentColorTheme = localStorage.getItem('colorTheme');
        
        // Set initial color theme
        if (currentColorTheme && currentColorTheme !== 'default') {
            settingsContainer.classList.add('theme-' + currentColorTheme);
        }
        
        themeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const theme = this.getAttribute('data-theme');
                
                // Remove existing themes
                settingsContainer.classList.remove('theme-blue', 'theme-purple');
                
                if (theme !== 'default') {
                    settingsContainer.classList.add('theme-' + theme);
                    localStorage.setItem('colorTheme', theme);
                } else {
                    localStorage.removeItem('colorTheme');
                }
                
                // Show theme change notification
                const toastContainer = document.createElement('div');
                toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '11';
                
                toastContainer.innerHTML = `
                    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fa fa-palette me-2"></i>Tema berhasil diubah
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(toastContainer);
                const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), {
                    delay: 2000
                });
                toast.show();
            });
        });
        
        // High contrast mode toggle
        const highContrastToggle = document.getElementById('highContrastToggle');
        const currentContrast = localStorage.getItem('highContrast');
        
        // Set initial high contrast mode
        if (currentContrast === 'true') {
            document.body.classList.add('high-contrast');
        }
        
        if (highContrastToggle) {
            highContrastToggle.addEventListener('click', function() {
                document.body.classList.toggle('high-contrast');
                localStorage.setItem('highContrast', document.body.classList.contains('high-contrast'));
                
                // Show notification
                const toastContainer = document.createElement('div');
                toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '11';
                
                toastContainer.innerHTML = `
                    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fa fa-adjust me-2"></i>${document.body.classList.contains('high-contrast') ? 'Mode kontras tinggi diaktifkan' : 'Mode kontras tinggi dinonaktifkan'}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(toastContainer);
                const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), {
                    delay: 2000
                });
                toast.show();
            });
        }
        
        // Improved keyboard navigation
        const tabButtons = document.querySelectorAll('.nav-tabs .nav-link');
        const formControls = document.querySelectorAll('input, select, button:not([disabled]), a[href]:not([tabindex="-1"])');
        
        // Add keyboard navigation for tabs
        tabButtons.forEach(button => {
            button.addEventListener('keydown', function(e) {
                // Arrow right or arrow down to move to next tab
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextTab = this.closest('.nav-item').nextElementSibling;
                    if (nextTab) {
                        nextTab.querySelector('.nav-link').click();
                        nextTab.querySelector('.nav-link').focus();
                    }
                }
                
                // Arrow left or arrow up to move to previous tab
                if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prevTab = this.closest('.nav-item').previousElementSibling;
                    if (prevTab) {
                        prevTab.querySelector('.nav-link').click();
                        prevTab.querySelector('.nav-link').focus();
                    }
                }
            });
        });
        
        // Improve form controls accessibility
        formControls.forEach(control => {
            // Add aria attributes for better screen reader support
            if (control.type === 'checkbox' || control.type === 'radio') {
                if (!control.hasAttribute('aria-checked')) {
                    control.setAttribute('aria-checked', control.checked);
                }
                
                control.addEventListener('change', function() {
                    this.setAttribute('aria-checked', this.checked);
                });
            }
            
            // Add keyboard support for range inputs
            if (control.type === 'range') {
                control.addEventListener('keydown', function(e) {
                    let value = parseInt(this.value);
                    const step = parseInt(this.getAttribute('step') || 1);
                    const min = parseInt(this.getAttribute('min') || 0);
                    const max = parseInt(this.getAttribute('max') || 100);
                    
                    if (e.key === 'ArrowRight' || e.key === 'ArrowUp') {
                        value = Math.min(value + step, max);
                        this.value = value;
                        const event = new Event('input');
                        this.dispatchEvent(event);
                    }
                    
                    if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') {
                        value = Math.max(value - step, min);
                        this.value = value;
                        const event = new Event('input');
                        this.dispatchEvent(event);
                    }
                    
                    if (e.key === 'Home') {
                        this.value = min;
                        const event = new Event('input');
                        this.dispatchEvent(event);
                    }
                    
                    if (e.key === 'End') {
                        this.value = max;
                        const event = new Event('input');
                        this.dispatchEvent(event);
                    }
                });
            }
        });
        
        // Support for reduced motion preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (prefersReducedMotion.matches) {
            document.body.classList.add('reduced-motion');
        }

        // Form validation for settings
        const settingsForms = document.querySelectorAll('.settings-section form');
        
        // Function to show validation errors
        function showValidationError(input, message) {
            // Remove any existing error message
            const existingError = input.parentElement.querySelector('.validation-error');
            if (existingError) {
                existingError.remove();
            }
            
            // Create and add the error message
            const errorElement = document.createElement('div');
            errorElement.className = 'validation-error text-danger small mt-1';
            errorElement.innerHTML = `<i class="fa fa-exclamation-circle me-1"></i>${message}`;
            
            // For checkbox/radio inputs, add after the form-text
            if (input.type === 'checkbox' || input.type === 'radio') {
                const formText = input.closest('.form-check').querySelector('.form-text');
                if (formText) {
                    formText.after(errorElement);
                } else {
                    input.closest('.form-check').appendChild(errorElement);
                }
            } else {
                // For other inputs, add after the input
                input.after(errorElement);
            }
            
            // Highlight the input
            input.classList.add('is-invalid');
            
            return false;
        }
        
        // Function to clear validation errors
        function clearValidationError(input) {
            const error = input.parentElement.querySelector('.validation-error');
            if (error) {
                error.remove();
            }
            input.classList.remove('is-invalid');
        }
        
        // Add custom validation to forms
        settingsForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Get all inputs in this form
                const inputs = form.querySelectorAll('input, select, textarea');
                
                inputs.forEach(input => {
                    // Clear existing validation errors
                    clearValidationError(input);
                    
                    // Validate Donation Radius
                    if (input.id === 'donationRadius') {
                        const value = parseInt(input.value);
                        if (isNaN(value) || value < 1 || value > 100) {
                            isValid = false;
                            showValidationError(input, 'Radius donasi harus antara 1-100 km.');
                        }
                    }
                    
                    // Validate email if present
                    if (input.type === 'email' && input.value) {
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(input.value)) {
                            isValid = false;
                            showValidationError(input, 'Format email tidak valid.');
                        }
                    }
                    
                    // Check required fields
                    if (input.hasAttribute('required') && !input.value.trim()) {
                        isValid = false;
                        showValidationError(input, 'Bidang ini wajib diisi.');
                    }
                    
                    // Special validation for checkbox groups
                    if (input.name === 'donationCategories[]') {
                        // Check if at least one category is selected
                        const checkboxes = form.querySelectorAll('input[name="donationCategories[]"]:checked');
                        if (checkboxes.length === 0 && input === form.querySelector('input[name="donationCategories[]"]')) {
                            isValid = false;
                            showValidationError(input, 'Pilih setidaknya satu kategori donasi.');
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Show error notification
                    const toastContainer = document.createElement('div');
                    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                    toastContainer.style.zIndex = '11';
                    
                    toastContainer.innerHTML = `
                        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa fa-exclamation-circle me-2"></i>Harap perbaiki kesalahan dalam formulir
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(toastContainer);
                    const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), {
                        delay: 3000
                    });
                    toast.show();
                    
                    // Jump to first error
                    const firstError = form.querySelector('.validation-error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    // If form is valid, show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Menyimpan...';
                    submitBtn.disabled = true;
                }
            });
        });        // Data export functionality
        const exportButtons = document.querySelectorAll('#exportProfileJson, #exportProfileCsv, #exportActivityJson, #exportActivityCsv');
        
        exportButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Determine export type and format
                const isProfile = this.id.includes('Profile');
                const isJson = this.id.includes('Json');
                const exportType = isProfile ? 'profile' : 'activity';
                const format = isJson ? 'json' : 'csv';
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = `<i class="fa fa-spinner fa-spin me-1"></i>Memproses...`;
                this.disabled = true;
                
                // Create and submit hidden form to handle download
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = `{{ route('settings.export', ['type' => '_type_', 'format' => '_format_']) }}`.replace('_type_', exportType).replace('_format_', format);
                document.body.appendChild(form);
                
                form.submit();
                document.body.removeChild(form);
                
                // Reset button state after a delay
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    
                    // Show success notification
                    const toastContainer = document.createElement('div');
                    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                    toastContainer.style.zIndex = '11';
                    
                    toastContainer.innerHTML = `
                        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa fa-check-circle me-2"></i>Data ${isProfile ? 'profil' : 'aktivitas'} berhasil diunduh
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(toastContainer);
                    const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), {
                        delay: 3000
                    });
                    toast.show();
                }, 1500);
            });
        });
    });
</script>
@endsection
