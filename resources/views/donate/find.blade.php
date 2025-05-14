@extends('layouts.admin.master')

@section('title', 'Cari Donasi - No Food Waste')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<link rel="stylesheet" href="{{ asset('assets/css/find-donations.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="page-header-left">
                    <h3>Cari Donasi Makanan</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Cari Donasi</li>
                    </ol>
                </div>
            </div>            <div class="col-lg-6">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('find-donations') }}" method="GET" class="w-100 d-flex justify-content-end">
                        <div class="input-group" style="max-width: 400px;">
                            <input type="text" class="form-control" id="searchKeyword" name="search" placeholder="Cari donasi makanan..." value="{{ request('search') }}">
                            <button class="btn btn-light" type="submit" id="searchBtn" aria-label="Cari Donasi">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="search-container">
        <!-- Search Filters Sidebar -->
        <div class="search-filters">
            <div class="search-filters-header">
                <h4 class="search-filters-title">Filter</h4>
                <a href="#" class="search-filters-reset" id="resetFilters">
                    <i class="fas fa-redo-alt"></i> Reset
                </a>
            </div>            <div class="search-filters-body">
                <form id="filterForm" action="{{ route('find-donations') }}" method="GET">
                    @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <div class="filter-group">
                        <label class="filter-label">Kategori Makanan</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="all" id="categoryAll" {{ request('category', 'all') == 'all' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoryAll">
                                Semua Kategori
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="makanan-siap-saji" id="categorySiapSaji" {{ request('category') == 'makanan-siap-saji' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categorySiapSaji">
                                Makanan Siap Saji
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="bahan-makanan" id="categoryBahan" {{ request('category') == 'bahan-makanan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoryBahan">
                                Bahan Makanan
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="roti-kue" id="categoryRoti" {{ request('category') == 'roti-kue' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoryRoti">
                                Roti & Kue
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="buah-sayur" id="categoryBuah" {{ request('category') == 'buah-sayur' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoryBuah">
                                Buah & Sayur
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="makanan-kaleng" id="categoryKaleng" {{ request('category') == 'makanan-kaleng' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoryKaleng">
                                Makanan Kaleng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="minuman" id="categoryMinuman" {{ request('category') == 'minuman' ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoryMinuman">
                                Minuman
                            </label>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Jarak (km)</label>
                        <div class="range-inputs">
                            <input type="number" class="form-control" id="distanceMin" name="distance_min" placeholder="Min" min="0" max="100" value="{{ request('distance_min') }}">
                            <span class="range-dash">-</span>
                            <input type="number" class="form-control" id="distanceMax" name="distance_max" placeholder="Max" min="0" max="100" value="{{ request('distance_max') }}">
                        </div>
                    </div>
                      <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="statusAll" value="all" {{ request('status', 'all') == 'all' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusAll">
                                Semua
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="statusAvailable" value="available" {{ request('status') == 'available' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusAvailable">
                                Tersedia
                            </label>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Waktu Pengambilan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="pickupDate" name="pickup_date" placeholder="Pilih tanggal" value="{{ request('pickup_date') }}">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Kuantitas Minimum</label>
                        <input type="number" class="form-control" id="quantityMin" name="quantity_min" placeholder="Jumlah minimum" min="1" value="{{ request('quantity_min') }}">
                    </div>
                    
                    <input type="hidden" name="sort" id="sortInput" value="{{ request('sort', 'nearest') }}">
                    
                    <button type="submit" class="btn btn-primary btn-filter" id="applyFilters">
                        <i class="fas fa-filter me-2"></i>Terapkan Filter
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="search-content">
            <!-- Map View -->
            <div class="search-map-container">
                <div class="search-map-header">
                    <h4 class="search-map-title">Peta Donasi</h4>
                    <div class="search-map-actions">
                        <div class="search-map-action" id="centerMap" role="button" tabindex="0" aria-label="Pusatkan Peta" title="Pusatkan Peta">
                            <i class="fas fa-crosshairs" aria-hidden="true"></i>
                        </div>
                        <div class="search-map-action" id="toggleFullMap" role="button" tabindex="0" aria-label="Perbesar Peta" title="Perbesar Peta">
                            <i class="fas fa-expand" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="search-map-body">
                    <div id="donationMap" class="donation-map"></div>
                </div>
            </div>
              <!-- Donation Results -->
            <div class="donation-results">
                <div class="donation-results-header">
                    <h4 class="donation-results-title">Hasil Pencarian <span class="donation-results-count">({{ $donations->total() }})</span></h4>
                    <div class="donation-results-sort">
                        <span class="donation-results-sort-label">Urutkan:</span>
                        <select class="donation-results-sort-select" id="sortResults">
                            <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Terdekat</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="expiry" {{ request('sort') == 'expiry' ? 'selected' : '' }}>Kedaluwarsa Terdekat</option>
                            <option value="quantity-high" {{ request('sort') == 'quantity-high' ? 'selected' : '' }}>Jumlah (Tertinggi)</option>
                            <option value="quantity-low" {{ request('sort') == 'quantity-low' ? 'selected' : '' }}>Jumlah (Terendah)</option>
                        </select>
                    </div>
                </div>
                
                @if($donations->count() > 0)
                <div class="donation-grid">
                    @foreach($donations as $donation)
                    <!-- Donation Card -->
                    <div class="donation-card">
                        <div class="donation-image">
                            @if($donation->image)
                                <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->food_name }}">
                            @else
                                <img src="{{ asset('assets/images/food-placeholder.jpg') }}" alt="{{ $donation->food_name }}">
                            @endif
                            <div class="donation-status available">Tersedia</div>
                            <div class="donation-distance">
                                <i class="fas fa-map-marker-alt"></i> 
                                @if(isset($donation->distance))
                                    {{ number_format($donation->distance, 1) }} km
                                @else
                                    <span title="Jarak tidak tersedia">--</span>
                                @endif
                            </div>
                        </div>
                        <div class="donation-body">
                            <h4 class="donation-title">{{ $donation->food_name }}</h4>                            <div class="donation-meta">
                                <div class="donation-meta-item">
                                    <i class="fas fa-calendar"></i> 
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($donation->expiration_date);
                                        $now = \Carbon\Carbon::now();
                                        $diffHours = $now->diffInHours($expiryDate, false);
                                        $diffDays = $now->diffInDays($expiryDate, false);
                                    @endphp
                                    
                                    @if($diffHours < 24)
                                        Kedaluwarsa: {{ $diffHours }} Jam
                                    @else
                                        Kedaluwarsa: {{ $diffDays }} Hari
                                    @endif
                                </div>
                                <div class="donation-meta-item">
                                    <i class="fas fa-box"></i> {{ $donation->quantity }} {{ $donation->unit ?? 'Porsi' }}
                                </div>
                            </div>
                            <p class="donation-description">
                                {{ $donation->description ?? 'Tidak ada deskripsi' }}
                            </p>
                            <div class="donation-footer">
                                <div class="donation-donor">
                                    <img src="{{ asset($donation->donor->profile_image ?? 'assets/images/user-placeholder.jpg') }}" alt="Donor" class="donation-donor-avatar">
                                    <span class="donation-donor-name">{{ $donation->donor->name }}</span>
                                </div>
                                <a href="{{ route('donations.claim.form', $donation->donation_id) }}" class="donation-action">Ambil</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="pagination-container mt-4">
                    @if ($donations->hasPages())
                        <nav aria-label="Navigasi halaman donasi">
                            <ul class="pagination justify-content-center mb-0">
                                {{-- Tombol Previous --}}
                                <li class="page-item{{ $donations->onFirstPage() ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $donations->previousPageUrl() ?? '#' }}" tabindex="{{ $donations->onFirstPage() ? '-1' : '0' }}" aria-disabled="{{ $donations->onFirstPage() ? 'true' : 'false' }}" aria-label="Sebelumnya">
                                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                                    </a>
                                </li>
                                {{-- Nomor Halaman --}}
                                @foreach ($donations->getUrlRange(1, $donations->lastPage()) as $page => $url)
                                    <li class="page-item{{ $page == $donations->currentPage() ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $url }}" aria-current="{{ $page == $donations->currentPage() ? 'page' : false }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                {{-- Tombol Next --}}
                                <li class="page-item{{ $donations->hasMorePages() ? '' : ' disabled' }}">
                                    <a class="page-link" href="{{ $donations->nextPageUrl() ?? '#' }}" tabindex="{{ $donations->hasMorePages() ? '0' : '-1' }}" aria-disabled="{{ $donations->hasMorePages() ? 'false' : 'true' }}" aria-label="Berikutnya">
                                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
                @else
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="no-results-title">Tidak Ada Donasi Ditemukan</h3>
                    <p class="no-results-text">Maaf, kami tidak dapat menemukan donasi yang cocok dengan kriteria pencarian Anda. Coba ubah filter atau cari lagi nanti.</p>
                    <a href="{{ route('find-donations') }}" class="btn btn-primary">Lihat Semua Donasi</a>
                </div>
                @endif
            </div>
                    
                <!-- Hapus data hardcoded: Kartu donasi dummy & pagination dummy sudah dihapus, seluruh data donasi kini berasal dari database. -->
            </div>
        </div>
    </div>
</div>

<!-- Mobile Filters Toggle Button -->
<div class="mobile-filters-toggle" id="showMobileFilters" role="button" tabindex="0" aria-label="Tampilkan Filter Mobile">
    <i class="fas fa-filter" aria-hidden="true"></i>
</div>

<!-- Mobile Filters Panel -->
<div class="mobile-filters" id="mobileFiltersPanel">
    <div class="mobile-filters-header">
        <h4 class="mobile-filters-title">Filter</h4>
        <div class="mobile-filters-close" id="closeMobileFilters" role="button" tabindex="0" aria-label="Tutup Filter Mobile">
            <i class="fas fa-times" aria-hidden="true"></i>
        </div>
    </div>
    <div class="mobile-filters-body">
        <form id="mobileFilterForm" action="{{ route('find-donations') }}" method="GET">
            @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div class="filter-group">
                <label class="filter-label">Kategori Makanan</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="all" id="mobileCategoryAll" {{ request('category', 'all') == 'all' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategoryAll">Semua Kategori</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="makanan-siap-saji" id="mobileCategorySiapSaji" {{ request('category') == 'makanan-siap-saji' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategorySiapSaji">Makanan Siap Saji</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="bahan-makanan" id="mobileCategoryBahan" {{ request('category') == 'bahan-makanan' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategoryBahan">Bahan Makanan</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="roti-kue" id="mobileCategoryRoti" {{ request('category') == 'roti-kue' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategoryRoti">Roti & Kue</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="buah-sayur" id="mobileCategoryBuah" {{ request('category') == 'buah-sayur' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategoryBuah">Buah & Sayur</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="makanan-kaleng" id="mobileCategoryKaleng" {{ request('category') == 'makanan-kaleng' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategoryKaleng">Makanan Kaleng</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="category" value="minuman" id="mobileCategoryMinuman" {{ request('category') == 'minuman' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileCategoryMinuman">Minuman</label>
                </div>
            </div>
            <div class="filter-group">
                <label class="filter-label">Jarak (km)</label>
                <div class="range-inputs">
                    <input type="number" class="form-control" id="mobileDistanceMin" name="distance_min" placeholder="Min" min="0" max="100" value="{{ request('distance_min') }}">
                    <span class="range-dash">-</span>
                    <input type="number" class="form-control" id="mobileDistanceMax" name="distance_max" placeholder="Max" min="0" max="100" value="{{ request('distance_max') }}">
                </div>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="status" id="mobileStatusAll" value="all" {{ request('status', 'all') == 'all' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileStatusAll">Semua</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="status" id="mobileStatusAvailable" value="available" {{ request('status') == 'available' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobileStatusAvailable">Tersedia</label>
                </div>
            </div>
            <div class="filter-group">
                <label class="filter-label">Waktu Pengambilan</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="mobilePickupDate" name="pickup_date" placeholder="Pilih tanggal" value="{{ request('pickup_date') }}">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
            </div>
            <div class="filter-group">
                <label class="filter-label">Kuantitas Minimum</label>
                <input type="number" class="form-control" id="mobileQuantityMin" name="quantity_min" placeholder="Jumlah minimum" min="1" value="{{ request('quantity_min') }}">
            </div>
            <input type="hidden" name="sort" id="mobileSortInput" value="{{ request('sort', 'nearest') }}">
            <button type="submit" class="btn btn-primary btn-filter w-100" id="applyMobileFilters">
                <i class="fas fa-filter me-2"></i>Terapkan Filter
            </button>
        </form>
    </div>
    <div class="mobile-filters-actions">
        <button type="button" class="btn btn-outline-secondary w-50" id="resetMobileFilters">
            <i class="fas fa-redo-alt me-2"></i>Reset
        </button>
        <button type="button" class="btn btn-primary w-50" id="applyMobileFiltersBtn">
            <i class="fas fa-filter me-2"></i>Terapkan
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    // Data untuk JS eksternal
    const foodMarkerUrl = "{{ asset('assets/images/food-marker.png') }}";
    const userMarkerUrl = "{{ asset('assets/images/user-marker.png') }}";
    const getNearbyDonationsUrl = "{{ route('get-nearby-donations') }}";
    const findDonationsUrl = "{{ route('find-donations') }}";
    // Data filter untuk AJAX (hanya contoh, bisa dikembangkan sesuai kebutuhan)
    const filterAjaxData = {
        search: "{{ request('search') }}",
        category: "{{ request('category') }}",
        status: "{{ request('status') }}",
        pickup_date: "{{ request('pickup_date') }}",
        quantity_min: "{{ request('quantity_min') }}"
    };
    // Data marker donasi untuk map (dari server)
    const donationMarkersData = [
        @if(isset($donations))
            @foreach($donations as $donation)
                @if($donation->latitude && $donation->longitude)
                {
                    latitude: {{ $donation->latitude }},
                    longitude: {{ $donation->longitude }},
                    popupContent: `
                        <div class="map-popup">
                            <div class="map-popup-image">
                                <img src="{{ $donation->image ? asset('storage/' . $donation->image) : asset('assets/images/food-placeholder.jpg') }}" alt="{{ $donation->food_name }}">
                            </div>
                            <div class="map-popup-content">
                                <h5 class="map-popup-title">{{ $donation->food_name }}</h5>
                                <div class="map-popup-meta">
                                    <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($donation->expiration_date)->diffForHumans() }}</span>
                                    <span><i class="fas fa-box"></i> {{ $donation->quantity }}</span>
                                </div>
                                <div class="map-popup-footer">
                                    <div class="map-popup-distance">
                                        @if(isset($donation->distance))
                                            {{ number_format($donation->distance, 1) }} km
                                        @else
                                            Jarak tidak tersedia
                                        @endif
                                    </div>
                                    <a href="{{ route('donations.claim.form', $donation->donation_id) }}" class="map-popup-action">Ambil</a>
                                </div>
                            </div>
                        </div>
                    `
                },
                @endif
            @endforeach
        @endif
    ];
</script>
<script src="{{ asset('assets/js/find-donations.js') }}"></script>

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/find-donations.css') }}">
<style>
/* Indikator loading filter */
#filterLoadingOverlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(255,255,255,0.7);
  z-index: 2000;
  display: none;
  align-items: center;
  justify-content: center;
}
#filterLoadingOverlay .spinner-border {
  width: 3rem;
  height: 3rem;
}
/* Responsive improvement for filter sidebar */
@media (max-width: 992px) {
  .search-filters { display: none !important; }
  .mobile-filters-toggle { display: flex !important; }
}
@media (max-width: 768px) {
  .donation-results-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
  .donation-results-sort { width: 100%; justify-content: space-between; }
}
</style>
@endpush
<div id="filterLoadingOverlay" aria-label="Memuat hasil pencarian" role="status">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>
<script>
// Tampilkan indikator loading saat filter/submit & validasi
$(function() {
  function showLoading() {
    $('#filterLoadingOverlay').fadeIn(100);
  }
  function hideLoading() {
    $('#filterLoadingOverlay').fadeOut(100);
  }
  // Validasi filter (desktop & mobile)
  function validateFilter(form) {
    let valid = true;
    // Jarak
    let min = parseFloat($(form).find('[name="distance_min"]').val());
    let max = parseFloat($(form).find('[name="distance_max"]').val());
    if (!isNaN(min) && !isNaN(max) && min > max) {
      alert('Jarak minimum tidak boleh lebih besar dari maksimum.');
      valid = false;
    }
    // Kuantitas
    let qmin = parseFloat($(form).find('[name="quantity_min"]').val());
    if (!isNaN(qmin) && qmin < 1) {
      alert('Kuantitas minimum harus lebih dari 0.');
      valid = false;
    }
    // Tanggal (optional, validasi format)
    let date = $(form).find('[name="pickup_date"]').val();
    if (date && !/^\d{4}-\d{2}-\d{2}$/.test(date)) {
      alert('Format tanggal tidak valid.');
      valid = false;
    }
    return valid;
  }
  // Form desktop
  $('#filterForm').on('submit', function(e) {
    if (!validateFilter(this)) { e.preventDefault(); return false; }
    showLoading();
  });
  // Form mobile
  $('#mobileFilterForm').on('submit', function(e) {
    if (!validateFilter(this)) { e.preventDefault(); return false; }
    showLoading();
  });
  // Search form
  $('form[action="{{ route('find-donations') }}"][method="GET"]').on('submit', function() {
    showLoading();
  });
  // Sembunyikan loading saat halaman selesai
  $(window).on('pageshow load', function() {
    hideLoading();
  });
});
</script>
@endpush
