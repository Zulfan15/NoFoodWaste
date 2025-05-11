@extends('layouts.admin.master')

@section('title', 'Pengaturan Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pengaturan Pengguna</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="true">Notifikasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">Privasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">Akun</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3" id="settingsTabContent">                        <!-- Notifications Settings -->
                        <div class="tab-pane fade show active" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <h5 class="mb-4">Pengaturan Notifikasi</h5>
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="settings_type" value="notifications">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="emailNotifications" name="emailNotifications" value="1" {{ old('emailNotifications', $user->email_notifications ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="emailNotifications">Notifikasi Email</label>
                                    </div>
                                    <div class="form-text">Terima notifikasi melalui email</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="donationAlerts" name="donationAlerts" value="1" {{ old('donationAlerts', $user->donation_alerts ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="donationAlerts">Pemberitahuan Donasi Baru</label>
                                    </div>
                                    <div class="form-text">Dapatkan pemberitahuan ketika donasi baru tersedia di sekitar Anda</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="claimUpdates" name="claimUpdates" value="1" {{ old('claimUpdates', $user->claim_updates ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="claimUpdates">Update Status Klaim</label>
                                    </div>
                                    <div class="form-text">Dapatkan pemberitahuan ketika status klaim Anda berubah</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="newsUpdates" name="newsUpdates" value="1" {{ old('newsUpdates', $user->news_updates ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="newsUpdates">Berita & Update</label>
                                    </div>
                                    <div class="form-text">Dapatkan berita terbaru tentang program dan fitur</div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                        </div>
                          <!-- Privacy Settings -->
                        <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                            <h5 class="mb-4">Pengaturan Privasi</h5>
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="settings_type" value="privacy">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="profileVisibility" name="profileVisibility" value="1" {{ old('profileVisibility', $user->profile_visibility ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="profileVisibility">Profil Publik</label>
                                    </div>
                                    <div class="form-text">Izinkan pengguna lain melihat profil Anda</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="locationSharing" name="locationSharing" value="1" {{ old('locationSharing', $user->location_sharing ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="locationSharing">Bagikan Lokasi</label>
                                    </div>
                                    <div class="form-text">Tampilkan lokasi Anda untuk memudahkan proses donasi</div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activityTracking" name="activityTracking" value="1" {{ old('activityTracking', $user->activity_tracking ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activityTracking">Lacak Aktivitas</label>
                                    </div>
                                    <div class="form-text">Izinkan sistem melacak aktivitas Anda untuk personalisasi</div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                        </div>
                          <!-- Account Settings -->
                        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <h5 class="mb-4">Pengaturan Akun</h5>
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="settings_type" value="account">
                                <div class="mb-3">
                                    <label for="language" class="form-label">Bahasa</label>
                                    <select class="form-select" id="language" name="language">
                                        <option value="id" {{ old('language', $user->language ?? 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                        <option value="en" {{ old('language', $user->language ?? 'id') == 'en' ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">Zona Waktu</label>
                                    <select class="form-select" id="timezone" name="timezone">
                                        <option value="Asia/Jakarta" {{ old('timezone', $user->timezone ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (GMT+7)</option>
                                        <option value="Asia/Makassar" {{ old('timezone', $user->timezone ?? 'Asia/Jakarta') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (GMT+8)</option>
                                        <option value="Asia/Jayapura" {{ old('timezone', $user->timezone ?? 'Asia/Jakarta') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (GMT+9)</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="twoFactorAuth" name="twoFactorAuth" value="1" {{ old('twoFactorAuth', $user->two_factor_auth ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="twoFactorAuth">Autentikasi Dua Faktor</label>
                                    </div>
                                    <div class="form-text">Aktifkan autentikasi dua faktor untuk keamanan tambahan</div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>                            </form>
                            
                            <hr class="my-4">
                            
                            <div class="account-danger-zone">
                                <h5 class="text-danger">Zona Berbahaya</h5>
                                <p>Tindakan di bawah ini dapat berdampak permanen pada akun Anda</p>
                                
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                        Nonaktifkan Akun
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        Hapus Akun
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

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.deactivate') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deactivateModalLabel">Nonaktifkan Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-warning">Nonaktifkan Akun</button>
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
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <p>Apakah Anda yakin ingin menghapus akun Anda secara permanen? Semua data Anda akan dihapus dan tidak dapat dipulihkan.</p>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
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
        // Aktifkan semua popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    });
</script>
@endsection
