@extends('layouts.admin.master')

@section('title', 'Dashboard - No Food Waste')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-creative.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />
@endpush

@section('content')
<div class="container-fluid">    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h3>Dashboard</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div class="user-dropdown dropdown">            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-2"></i>{{ Auth::check() ? Auth::user()->username : 'Pengguna' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>      <!-- Welcome Banner -->
    <div class="dashboard-welcome-banner">
        <div class="dashboard-welcome-content">
            <h2 class="dashboard-welcome-title">Selamat Datang, {{ Auth::check() ? Auth::user()->username : 'Pengguna' }}!</h2>
            <p class="dashboard-welcome-text">
                Hari ini adalah hari yang tepat untuk berbagi kebaikan. Mari kita perkuat komitmen untuk mengurangi pemborosan makanan dan membantu mereka yang membutuhkan.
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('donate') }}" class="btn btn-light">
                    <i class="fas fa-hand-holding-heart me-2"></i>Donasi Makanan
                </a>
                <a href="{{ route('find-donations') }}" class="btn btn-outline-light">
                    <i class="fas fa-search me-2"></i>Cari Donasi
                </a>
            </div>
        </div>
        <div class="dashboard-welcome-image">
            <img src="{{ asset('assets/images/food-sharing.jpg') }}" alt="Food Sharing">
            <div class="dashboard-welcome-overlay"></div>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="dashboard-overview">
        <div class="dashboard-stat-grid">            <!-- Food Saved -->
            <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                <div class="stat-header">
                    <h5 class="stat-title">Makanan Terselamatkan</h5>
                    <div class="stat-icon food">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        <span class="counter" data-target="750">0</span><span class="stat-unit">Kg</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>15.3%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Active Users -->
            <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="stat-header">
                    <h5 class="stat-title">Pengguna Aktif</h5>
                    <div class="stat-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        <span class="counter" data-target="325">0</span><span class="stat-unit">Pengguna</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>8.7%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Successful Donations -->
            <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                <div class="stat-header">
                    <h5 class="stat-title">Donasi Berhasil</h5>
                    <div class="stat-icon donations">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        <span class="counter" data-target="128">0</span><span class="stat-unit">Donasi</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>23.5%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Communities Helped -->
            <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                <div class="stat-header">
                    <h5 class="stat-title">Komunitas Terbantu</h5>
                    <div class="stat-icon communities">
                        <i class="fas fa-place-of-worship"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        <span class="counter" data-target="42">0</span><span class="stat-unit">Komunitas</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>4.2%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>        </div>
    </div>      <!-- Quick Actions -->
    <div class="quick-actions mb-4">
        <div class="section-header mb-3">
            <h3 class="section-title">Aksi Cepat</h3>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('donate') }}" class="quick-action-card donate">
                <div class="quick-action-content">
                    <div class="quick-action-icon donate">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4 class="quick-action-title">Donasi Makanan</h4>
                    <p class="quick-action-description">Bagikan makanan berlebih kepada yang membutuhkan</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('find-donations') }}" class="quick-action-card find">
                <div class="quick-action-content">
                    <div class="quick-action-icon find">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 class="quick-action-title">Cari Donasi</h4>
                    <p class="quick-action-description">Temukan donasi makanan di sekitar lokasi Anda</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="{{ route('leaderboard') }}" class="quick-action-card leaderboard">
                <div class="quick-action-content">
                    <div class="quick-action-icon leaderboard">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h4 class="quick-action-title">Leaderboard</h4>
                    <p class="quick-action-description">Lihat peringkat donatur terbaik bulan ini</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="#" class="quick-action-card profile">
                <div class="quick-action-content">
                    <div class="quick-action-icon profile">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h4 class="quick-action-title">Edit Profil</h4>
                    <p class="quick-action-description">Perbarui informasi dan preferensi akun Anda</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
    
      <!-- Charts Section -->
    <div class="dashboard-charts">
        <!-- Donation Trends Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h5 class="chart-title">Tren Donasi</h5>
                <div class="chart-actions">
                    <button class="chart-action-btn active" data-period="monthly">1 Bulan</button>
                    <button class="chart-action-btn" data-period="quarterly">3 Bulan</button>
                    <button class="chart-action-btn" data-period="yearly">1 Tahun</button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="donationTrendsChart" height="250"></canvas>
            </div>
        </div>
        
        <!-- Donation Map -->
        <div class="chart-card">
            <div class="chart-header">
            <h5 class="chart-title">Peta Donasi Aktif</h5>
            <div class="chart-actions">
                <button class="chart-action-btn" onclick="resetMap()">
                <i class="fas fa-redo-alt"></i>
                </button>
                <button class="chart-action-btn" onclick="locateUser()">
                <i class="fas fa-location-arrow"></i>
                </button>
            </div>
            </div>
            <div class="chart-body">
            <div id="donationMap" class="donation-map"></div>
            </div>
        </div>
    </div>
    
    <script>
    // Inisialisasi variabel global untuk peta
    let map;
    let userMarker;
    let markerCluster;
    let currentPosition = null;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi peta dengan jeda untuk memastikan container siap
        setTimeout(initMap, 500);
    });
    
    function initMap() {
        // Inisialisasi peta dengan koordinat default Jakarta
        map = L.map('donationMap').setView([-6.200000, 106.816666], 13);
        
        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | No Food Waste'
        }).addTo(map);
        
        // Custom icon untuk marker donasi makanan
        const foodIcon = createFoodIcon();
        
        // Tambahkan marker contoh jika tidak ada data dinamis
        @if(!isset($donations) || count($donations) === 0)
            // Data statis untuk contoh
            addMarker(-6.1754, 106.8272, 'Nasi Kotak Sisa Event', '25 Porsi', 'PT Seminar Indonesia', foodIcon);
            addMarker(-6.2088, 106.8456, 'Aneka Roti dan Kue', '15 Item', 'Bakery Delicious', foodIcon);
            addMarker(-6.1899, 106.8219, 'Sayuran Organik Segar', '8 Kg', 'Kebun Sayur Bahagia', foodIcon);
            addMarker(-6.1744, 106.7900, 'Buah-buahan Segar', '12 Kg', 'Toko Buah Sehat', foodIcon);
            addMarker(-6.2156, 106.8063, 'Menu Catering Sisa', '18 Porsi', 'Catering Lezat', foodIcon);
        @else
            // Gunakan data dinamis dari database
            @foreach($donations as $donation)
                try {
                    addMarker(
                        {{ $donation->latitude }},
                        {{ $donation->longitude }},
                        '{{ addslashes($donation->title) }}',
                        '{{ addslashes($donation->quantity) }}',
                        '{{ addslashes($donation->donor_name) }}',
                        foodIcon
                    );
                } catch (e) {
                    console.error("Error adding marker:", e);
                }
            @endforeach
        @endif
    }
    
    // Fungsi untuk membuat icon makanan untuk marker
    function createFoodIcon() {
        return L.icon({
            iconUrl: '{{ asset('assets/images/food-marker.png') }}',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });
    }
    
    // Fungsi untuk membuat marker kustom jika icon bermasalah
    function createCustomMarker() {
        return L.divIcon({
            className: 'custom-marker',
            html: '<i class="fas fa-utensils"></i>',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });
    }
    
    // Fungsi untuk menambahkan marker ke peta
    function addMarker(lat, lng, title, quantity, donor, icon) {
        try {
            if (!lat || !lng) {
                console.error("Invalid coordinates for marker:", title);
                return;
            }
            
            // Fallback ke custom marker jika icon bermasalah
            let markerIcon;
            try {
                markerIcon = icon || createCustomMarker();
            } catch (e) {
                console.warn("Error loading icon, using custom marker", e);
                markerIcon = createCustomMarker();
            }
            
            const marker = L.marker([lat, lng], {icon: markerIcon}).addTo(map);
            
            // Buat konten popup yang menarik
            const popupContent = `
                <div class="donation-popup">
                    <h5 class="popup-title">${title || 'Donasi Makanan'}</h5>
                    <div class="popup-meta">
                        <span><i class="fas fa-box me-2"></i>${quantity || 'N/A'}</span>
                    </div>
                    <div class="popup-donor">
                        <span><i class="fas fa-user me-2"></i>${donor || 'Anonim'}</span>
                    </div>
                    <a href="#" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            
            // Tambahkan hover effect
            marker.on('mouseover', function() {
                this.openPopup();
            });
            
            return marker;
        } catch (e) {
            console.error("Error creating marker:", e);
            return null;
        }
    }
    
    // Reset peta ke posisi awal
    function resetMap() {
        map.setView([-6.200000, 106.816666], 13);
    }
    
    // Cari lokasi pengguna saat ini
    function locateUser() {
        map.locate({setView: true, maxZoom: 16});
        
        map.on('locationfound', function(e) {
            currentPosition = e.latlng;
            
            // Hapus marker lama jika ada
            if (userMarker) {
                map.removeLayer(userMarker);
            }
            
            // Buat marker baru dengan posisi user
            const userIcon = L.divIcon({
                className: 'user-location-marker',
                html: '<i class="fas fa-user-circle"></i>',
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });
            
            userMarker = L.marker(e.latlng, {icon: userIcon}).addTo(map);
            userMarker.bindPopup("Anda berada di sini").openPopup();
            
            // Tambahkan radius akurasi
            const radius = e.accuracy / 2;
            L.circle(e.latlng, radius, {
                color: '#4a89ff',
                fillColor: '#b6d3ff',
                fillOpacity: 0.15
            }).addTo(map);
        });
        
        map.on('locationerror', function(e) {
            alert("Tidak dapat menemukan lokasi Anda. " + e.message);
        });
    }    </script>      <!-- Recent Donations -->
    <div class="recent-donations">
        <div class="section-header">
            <h3 class="section-title">Donasi Terbaru</h3>
            <a href="{{ route('find-donations') }}" class="section-action">
                Lihat Semua <i class="fas fa-chevron-right"></i>
            </a>
        </div>
        <div class="donations-grid">
            <!-- Donation 1 -->
            <div class="donation-card">
                <div class="donation-image">
                    <img src="{{ asset('assets/images/food1.jpg') }}" alt="Nasi Kotak">
                    <div class="donation-status available">Tersedia</div>
                </div>
                <div class="donation-body">
                    <h4 class="donation-title">Nasi Kotak Sisa Event</h4>
                    <div class="donation-meta">
                        <div class="donation-meta-item">
                            <i class="fas fa-calendar"></i> Kedaluwarsa: 8 Jam
                        </div>
                        <div class="donation-meta-item">
                            <i class="fas fa-box"></i> 25 Porsi
                        </div>
                    </div>
                    <p class="donation-description">
                        Nasi kotak dengan lauk ayam, sayur dan kerupuk. Masih baru dan layak konsumsi, sisa dari acara seminar.
                    </p>
                    <div class="donation-footer">
                        <div class="donation-donor">
                            <img src="{{ asset('assets/images/user1.jpg') }}" alt="Donor" class="donation-donor-avatar">
                            <span class="donation-donor-name">PT Seminar Indonesia</span>
                        </div>
                        <a href="#" class="donation-action">Detail</a>
                    </div>
                </div>
            </div>
            
            <!-- Donation 2 -->
            <div class="donation-card">
                <div class="donation-image">
                    <img src="{{ asset('assets/images/food2.jpg') }}" alt="Roti dan Kue">
                    <div class="donation-status available">Tersedia</div>
                </div>
                <div class="donation-body">
                    <h4 class="donation-title">Aneka Roti dan Kue</h4>
                    <div class="donation-meta">
                        <div class="donation-meta-item">
                            <i class="fas fa-calendar"></i> Kedaluwarsa: 2 Hari
                        </div>
                        <div class="donation-meta-item">
                            <i class="fas fa-box"></i> 15 Item
                        </div>
                    </div>
                    <p class="donation-description">
                        Berbagai jenis roti dan kue dari toko kami yang tidak terjual hari ini. Masih segar dan lezat.
                    </p>
                    <div class="donation-footer">
                        <div class="donation-donor">
                            <img src="{{ asset('assets/images/user2.jpg') }}" alt="Donor" class="donation-donor-avatar">
                            <span class="donation-donor-name">Bakery Delicious</span>
                        </div>
                        <a href="#" class="donation-action">Detail</a>
                    </div>
                </div>
            </div>
            
            <!-- Donation 3 -->
            <div class="donation-card">
                <div class="donation-image">
                    <img src="{{ asset('assets/images/food3.jpg') }}" alt="Sayuran Segar">
                    <div class="donation-status available">Tersedia</div>
                </div>
                <div class="donation-body">
                    <h4 class="donation-title">Sayuran Organik Segar</h4>
                    <div class="donation-meta">
                        <div class="donation-meta-item">
                            <i class="fas fa-calendar"></i> Kedaluwarsa: 3 Hari
                        </div>
                        <div class="donation-meta-item">
                            <i class="fas fa-box"></i> 8 Kg
                        </div>
                    </div>
                    <p class="donation-description">
                        Sayuran organik segar dari kebun kami, termasuk wortel, bayam, dan kangkung. Dipanen pagi ini.
                    </p>
                    <div class="donation-footer">
                        <div class="donation-donor">
                            <img src="{{ asset('assets/images/user3.jpg') }}" alt="Donor" class="donation-donor-avatar">
                            <span class="donation-donor-name">Kebun Sayur Bahagia</span>
                        </div>
                        <a href="#" class="donation-action">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>      <!-- Leaderboard -->
    <div class="leaderboard-card">
        <div class="leaderboard-header">
            <h3 class="leaderboard-title">Top Donatur Bulan Ini</h3>
        </div>
        <div class="leaderboard-tabs">
            <div class="leaderboard-tab active" data-type="donors">Donatur</div>
            <div class="leaderboard-tab" data-type="communities">Penerima</div>
        </div>
        <div class="leaderboard-body" id="leaderboard-donors">
            @if(count($topDonors) > 0)
                @foreach($topDonors as $key => $donor)
                    <div class="leaderboard-item">
                        <div class="leaderboard-rank {{ $key < 3 ? 'top' : '' }}">{{ $key + 1 }}</div>
                        <div class="leaderboard-user">
                            <div class="leaderboard-avatar">
                                @if(isset($donor->profile_photo))
                                    <img src="{{ asset('storage/' . $donor->profile_photo) }}" alt="{{ $donor->username }}">
                                @else
                                    {{ strtoupper(substr($donor->username, 0, 2)) }}
                                @endif
                            </div>
                            <div class="leaderboard-user-info">
                                <div class="leaderboard-name">{{ $donor->username }}</div>
                                <div class="leaderboard-role">{{ ucfirst($donor->role) }}</div>
                            </div>
                        </div>
                        <div class="leaderboard-score">{{ $donor->total_donated }} Kg</div>
                    </div>
                @endforeach
            @else
                <div class="leaderboard-item">
                    <p class="text-center">Belum ada data donatur</p>
                </div>
            @endif
        </div>
        
        <div class="leaderboard-body" id="leaderboard-communities" style="display: none;">
            @if(count($topCommunities) > 0)
                @foreach($topCommunities as $key => $community)
                    <div class="leaderboard-item">
                        <div class="leaderboard-rank {{ $key < 3 ? 'top' : '' }}">{{ $key + 1 }}</div>
                        <div class="leaderboard-user">
                            <div class="leaderboard-avatar">
                                @if(isset($community->profile_photo))
                                    <img src="{{ asset('storage/' . $community->profile_photo) }}" alt="{{ $community->username }}">
                                @else
                                    {{ strtoupper(substr($community->username, 0, 2)) }}
                                @endif
                            </div>
                            <div class="leaderboard-user-info">
                                <div class="leaderboard-name">{{ $community->username }}</div>
                                <div class="leaderboard-role">{{ ucfirst($community->role) }}</div>
                            </div>
                        </div>
                        <div class="leaderboard-score">{{ $community->total_claims }} Klaim</div>
                    </div>
                @endforeach
            @else
                <div class="leaderboard-item">
                    <p class="text-center">Belum ada data komunitas</p>
                </div>
            @endif
        </div>
    </div>      <!-- Testimonials Slider -->
    <div class="section-header">
        <h3 class="section-title">Kisah Inspiratif</h3>
    </div>
    
    <div class="swiper testimonial-slider">
        <div class="swiper-wrapper">            <!-- Testimonial 1 -->
            <div class="swiper-slide">
                <div class="testimonial">
                    <div class="testimonial-image">
                        <img src="{{ asset('assets/images/makanan.jpeg') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            "Platform No Food Waste telah membantu kami menyalurkan makanan berlebih dari restoran kami kepada yang membutuhkan. Sangat mudah digunakan dan dampaknya luar biasa."
                        </p>
                        <div class="testimonial-author">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Author" class="testimonial-author-avatar">
                            <div class="testimonial-author-info">
                                <h4>Budi Santoso</h4>
                                <p>Owner, Resto Bahagia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="swiper-slide">
                <div class="testimonial">
                    <div class="testimonial-image">
                        <img src="{{ asset('assets/images/makanan.jpeg') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            "Sebagai pengelola panti asuhan, kami sangat terbantu dengan donasi makanan melalui platform ini. Anak-anak selalu senang mendapatkan makanan bergizi yang beragam."
                        </p>
                        <div class="testimonial-author">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Author" class="testimonial-author-avatar">
                            <div class="testimonial-author-info">
                                <h4>Ibu Siti</h4>
                                <p>Pengelola, Panti Asuhan Cahaya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="swiper-slide">
                <div class="testimonial">
                    <div class="testimonial-image">
                        <img src="{{ asset('assets/images/makanan.jpeg') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            "Setelah bergabung dengan komunitas No Food Waste, saya merasa lebih bermakna. Kini, makanan berlebih di toko kami tidak terbuang sia-sia, melainkan membantu sesama."
                        </p>
                        <div class="testimonial-author">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Author" class="testimonial-author-avatar">
                            <div class="testimonial-author-info">
                                <h4>Ahmad Ridwan</h4>
                                <p>Manajer, Supermarket Hemat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    // Inisialisasi chart tren donasi
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('donationTrendsChart').getContext('2d');
        
        // Data untuk chart
        const monthlyData = {
            labels: ['1 Jan', '7 Jan', '14 Jan', '21 Jan', '28 Jan', '4 Feb', '11 Feb', '18 Feb', '25 Feb', '4 Mar', '11 Mar', '18 Mar'],
            datasets: [
                {
                    label: 'Donasi (kg)',
                    data: [45, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
                    borderColor: '#2C6B2F',
                    backgroundColor: 'rgba(44, 107, 47, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#2C6B2F',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Makanan Terselamatkan (kg)',
                    data: [30, 45, 22, 81, 35, 53, 59, 79, 60, 52, 38, 85],
                    borderColor: '#F7941D',
                    backgroundColor: 'rgba(247, 148, 29, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#F7941D',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        };
        
        const quarterlyData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Donasi (kg)',
                    data: [450, 590, 600, 810, 560, 550, 400, 650, 590, 800, 810, 560],
                    borderColor: '#2C6B2F',
                    backgroundColor: 'rgba(44, 107, 47, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#2C6B2F',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Makanan Terselamatkan (kg)',
                    data: [300, 450, 390, 810, 350, 530, 590, 790, 600, 520, 380, 850],
                    borderColor: '#F7941D',
                    backgroundColor: 'rgba(247, 148, 29, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#F7941D',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        };
        
        const yearlyData = {
            labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
            datasets: [
                {
                    label: 'Donasi (kg)',
                    data: [4500, 5900, 6000, 8100, 7500, 9200],
                    borderColor: '#2C6B2F',
                    backgroundColor: 'rgba(44, 107, 47, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#2C6B2F',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Makanan Terselamatkan (kg)',
                    data: [3000, 4500, 3900, 8100, 5500, 7500],
                    borderColor: '#F7941D',
                    backgroundColor: 'rgba(247, 148, 29, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#F7941D',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        };
        
        // Opsi chart
        const options = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' kg';
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                line: {
                    tension: 0.4
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000
            }
        };
        
        // Inisialisasi chart
        const donationChart = new Chart(ctx, {
            type: 'line',
            data: monthlyData,
            options: options
        });
        
        // Handle periode chart
        const periodButtons = document.querySelectorAll('.chart-action-btn[data-period]');
        periodButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active state
                periodButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Update data sesuai periode
                const period = this.getAttribute('data-period');
                if (period === 'monthly') {
                    donationChart.data = monthlyData;
                } else if (period === 'quarterly') {
                    donationChart.data = quarterlyData;
                } else if (period === 'yearly') {
                    donationChart.data = yearlyData;
                }
                
                // Update chart
                donationChart.update();
            });
        });
    });
    
    // Inisialisasi Swiper untuk testimonial
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.testimonial-slider', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
    
    // Tab switching untuk leaderboard
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.leaderboard-tab');
        const donorsBoard = document.getElementById('leaderboard-donors');
        const communitiesBoard = document.getElementById('leaderboard-communities');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active state
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Tampilkan/sembunyikan konten tab
                const type = this.getAttribute('data-type');
                if (type === 'donors') {
                    donorsBoard.style.display = 'block';
                    communitiesBoard.style.display = 'none';
                } else {
                    donorsBoard.style.display = 'none';
                    communitiesBoard.style.display = 'block';
                }
            });
        });
    });
    
    // Counter animasi untuk statistik
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200; // Kecepatan animasi (makin rendah makin cepat)
        
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                
                // Hitung kecepatan increment berdasarkan target
                const inc = Math.ceil(target / speed);
                
                // Cek apakah sudah mencapai target
                if (count < target) {
                    // Tambahkan increment ke counter
                    counter.innerText = count + inc;
                    // Panggil fungsi setiap 1ms
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };
            
            // Mulai animasi counter
            updateCount();
        });
    });
</script>
@endpush
