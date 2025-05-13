@extends('layouts.admin.master')

@section('title', 'Leaderboard - No Food Waste')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
<!-- Chart.js for visualizations -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
<!-- Custom leaderboard styles -->
<link rel="stylesheet" href="{{ asset('assets/css/leaderboard.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->    <div class="page-header animate__animated animate__fadeIn">
        <div class="row">
            <div class="col-sm-6">
                <h3><i class="fa fa-trophy mr-2"></i> Leaderboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home mr-1"></i> Home</a></li>
                    <li class="breadcrumb-item active">Leaderboard</li>
                </ol>
            </div>
            <div class="col-sm-6 text-right d-none d-md-block">
                <div class="text-white">
                    <div class="d-inline-block p-2 bg-white bg-opacity-10 rounded">
                        <span id="current-date"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- Period Selection -->
    <div class="period-selector animate__animated animate__fadeIn" style="animation-delay: 0.1s">
        <a href="{{ route('leaderboard', ['period' => 'month']) }}" class="period-pill {{ $period == 'month' ? 'active' : '' }}">
            <i class="fa fa-calendar"></i> Bulan Ini
        </a>
        <a href="{{ route('leaderboard', ['period' => 'year']) }}" class="period-pill {{ $period == 'year' ? 'active' : '' }}">
            <i class="fa fa-calendar-check-o"></i> Tahun Ini
        </a>
        <a href="{{ route('leaderboard', ['period' => 'all']) }}" class="period-pill {{ $period == 'all' ? 'active' : '' }}">
            <i class="fa fa-history"></i> Sepanjang Waktu
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid animate__animated animate__fadeInUp" style="animation-delay: 0.2s">        <div class="stat-card">
            <div class="stat-icon" style="background: var(--success-gradient);">
                <i class="fa fa-utensils"></i>
            </div>
            <div class="stat-value">{{ number_format($totalDonated, 0, ',', '.') }} Kg</div>
            <div class="stat-label">Total Makanan Diselamatkan</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--info-gradient);">
                <i class="fa fa-users"></i>
            </div>
            <div class="stat-value">{{ $activeDonors }}</div>
            <div class="stat-label">Donatur Aktif</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--warning-gradient);">
                <i class="fa fa-users"></i>
            </div>
            <div class="stat-value">{{ $activeCommunities }}</div>
            <div class="stat-label">Penerima Aktif</div>
        </div>
    </div>
    
    <!-- Intro Card -->
    <div class="intro-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-star text-warning mr-3" style="font-size: 2rem;"></i>
                <h4 class="mb-0">Top Kontributor {{ $periodLabel }}</h4>
            </div>
            <p class="mb-3">Halaman ini menampilkan para donatur dan penerima makanan terbaik dalam platform No Food Waste periode {{ strtolower($periodLabel) }}. Misi kami adalah mengurangi limbah makanan dan membantu mereka yang membutuhkan.</p>
            <div class="alert alert-success d-flex align-items-center">
                <i class="fa fa-info-circle mr-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Data Terbaru:</strong> Data diperbarui secara berkala untuk mencerminkan kontribusi komunitas kami. Terakhir diperbarui pada {{ $lastUpdated }}.
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Section - Top Contributors Visualization -->
    <div class="chart-wrapper animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
        <div class="chart-header">
            <h5 class="chart-title"><i class="fa fa-bar-chart mr-2"></i> Visualisasi Kontribusi Top 5</h5>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-success active" id="chart-donors-btn">Donatur</button>
                <button class="btn btn-sm btn-outline-primary" id="chart-communities-btn">Penerima</button>
            </div>
        </div>
        <div class="chart-canvas-container">
            <canvas id="contributorsChart"></canvas>
        </div>
    </div>
    
    <!-- Leaderboard -->    <div class="leaderboard-card animate__animated animate__fadeInUp" style="animation-delay: 0.5s">
        <div class="leaderboard-header">
            <div>
                <h3 class="leaderboard-title"><i class="fa fa-star mr-2"></i> Top Donatur</h3>
                <div class="leaderboard-period">{{ $periodLabel }}</div>
            </div>
            <button class="leaderboard-refresh-btn" id="refresh-leaderboard" title="Refresh Data">
                <i class="fa fa-refresh"></i>
            </button>
        </div>
        
        <div class="leaderboard-tabs">
            <div class="leaderboard-tab active" data-type="donors">
                <i class="fa fa-handshake-o"></i> Donatur
            </div>
            <div class="leaderboard-tab" data-type="communities">
                <i class="fa fa-users"></i> Penerima
            </div>
        </div>
        
        <div class="leaderboard-summary">
            <div class="leaderboard-info">
                <i class="fa fa-info-circle"></i> 
                Menampilkan kontributor terbaik berdasarkan {{ $period == 'month' ? 'jumlah donasi bulan ini' : ($period == 'year' ? 'jumlah donasi tahun ini' : 'total donasi') }}
            </div>
            <div class="leaderboard-search">
                <i class="fa fa-search"></i>
                <input type="text" id="search-leaderboard" placeholder="Cari kontributor..." aria-label="Cari kontributor">
            </div>
        </div>
        
        <!-- Donors Leaderboard -->
        <div class="leaderboard-body" id="leaderboard-donors">
            <div class="leaderboard-loading" id="donors-loading" style="display: none;">
                <div class="spinner"></div>
                <div>Memuat data...</div>
            </div>
            
            @if(count($topDonors) > 0)
                @foreach($topDonors as $key => $donor)
                    <div class="leaderboard-item slide-in" style="animation-delay: {{ ($key * 0.1) + 0.1 }}s" data-name="{{ strtolower($donor->username) }}">
                        @if($key < 3)
                            <div class="trophy-badge {{ $key == 0 ? 'trophy-gold' : ($key == 1 ? 'trophy-silver' : 'trophy-bronze') }}">
                                <i class="fa fa-trophy"></i>
                            </div>
                        @endif
                        
                        <div class="leaderboard-rank {{ $key == 0 ? 'top-1' : ($key == 1 ? 'top-2' : ($key == 2 ? 'top-3' : '')) }}">
                            {{ $key + 1 }}
                            @php
                                $previousRank = isset($previousRanks[$donor->user_id]) ? $previousRanks[$donor->user_id] : null;
                                $rankChange = $previousRank ? ($previousRank - ($key + 1)) : 0;
                            @endphp
                            
                            @if($rankChange > 0)
                                <div class="rank-change rank-up" title="Naik {{ $rankChange }} peringkat">
                                    <i class="fa fa-arrow-up"></i>
                                </div>
                            @elseif($rankChange < 0)
                                <div class="rank-change rank-down" title="Turun {{ abs($rankChange) }} peringkat">
                                    <i class="fa fa-arrow-down"></i>
                                </div>
                            @elseif($previousRank)
                                <div class="rank-change rank-same" title="Peringkat tetap">
                                    <i class="fa fa-equals"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="leaderboard-user">
                            <div class="leaderboard-avatar">
                                @if(isset($donor->profile_photo))
                                    <img src="{{ asset('storage/' . $donor->profile_photo) }}" alt="{{ $donor->username }}" loading="lazy">
                                @else
                                    {{ strtoupper(substr($donor->username, 0, 2)) }}
                                @endif
                            </div>
                            <div class="leaderboard-user-info">
                                <div class="leaderboard-name">{{ $donor->username }}</div>
                <div class="leaderboard-role">
                                    <i class="fa fa-user"></i> {{ ucfirst($donor->role) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="progress-container d-none d-md-block">
                            <div class="progress-bar-bg">
                                <div class="progress-bar" style="width: {{ $key == 0 ? 100 : round(($donor->total_donated / $topDonors[0]->total_donated) * 100) }}%"></div>
                            </div>
                            <div class="progress-text">{{ $key == 0 ? 100 : round(($donor->total_donated / $topDonors[0]->total_donated) * 100) }}%</div>
                        </div>
                        
                        <div class="leaderboard-score">
                            <i class="fa fa-balance-scale"></i> {{ number_format($donor->total_donated, 0, ',', '.') }} Kg
                        </div>
                    </div>
                @endforeach
            @else                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <div class="empty-state-text">Belum ada data donatur untuk periode ini</div>
                    <a href="{{ route('donate') }}" class="empty-state-action">
                        <i class="fa fa-plus-circle"></i> Mulai Donasi Sekarang
                    </a>
                </div>
            @endif
        </div>
          
        <!-- Communities Leaderboard -->
        <div class="leaderboard-body" id="leaderboard-communities" style="display: none;">
            <div class="leaderboard-loading" id="communities-loading" style="display: none;">
                <div class="spinner"></div>
                <div>Memuat data...</div>
            </div>
            
            @if(count($topCommunities) > 0)
                @foreach($topCommunities as $key => $community)
                    <div class="leaderboard-item slide-in" style="animation-delay: {{ ($key * 0.1) + 0.1 }}s" data-name="{{ strtolower($community->username) }}">
                        @if($key < 3)
                            <div class="trophy-badge {{ $key == 0 ? 'trophy-gold' : ($key == 1 ? 'trophy-silver' : 'trophy-bronze') }}">
                                <i class="fa fa-trophy"></i>
                            </div>
                        @endif
                        
                        <div class="leaderboard-rank {{ $key == 0 ? 'top-1' : ($key == 1 ? 'top-2' : ($key == 2 ? 'top-3' : '')) }}">
                            {{ $key + 1 }}
                            @php
                                $previousRank = isset($previousRanks[$community->user_id]) ? $previousRanks[$community->user_id] : null;
                                $rankChange = $previousRank ? ($previousRank - ($key + 1)) : 0;
                            @endphp
                            
                            @if($rankChange > 0)
                                <div class="rank-change rank-up" title="Naik {{ $rankChange }} peringkat">
                                    <i class="fa fa-arrow-up"></i>
                                </div>
                            @elseif($rankChange < 0)
                                <div class="rank-change rank-down" title="Turun {{ abs($rankChange) }} peringkat">
                                    <i class="fa fa-arrow-down"></i>
                                </div>
                            @elseif($previousRank)
                                <div class="rank-change rank-same" title="Peringkat tetap">
                                    <i class="fa fa-equals"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="leaderboard-user">
                            <div class="leaderboard-avatar">
                                @if(isset($community->profile_photo))
                                    <img src="{{ asset('storage/' . $community->profile_photo) }}" alt="{{ $community->username }}" loading="lazy">
                                @else
                                    {{ strtoupper(substr($community->username, 0, 2)) }}
                                @endif
                            </div>
                            <div class="leaderboard-user-info">
                                <div class="leaderboard-name">{{ $community->username }}</div>
                                <div class="leaderboard-role">
                                    <i class="fa fa-users"></i> {{ ucfirst($community->role) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="progress-container d-none d-md-block">
                            <div class="progress-bar-bg">
                                <div class="progress-bar" style="width: {{ $key == 0 ? 100 : round(($community->total_claims / $topCommunities[0]->total_claims) * 100) }}%"></div>
                            </div>
                            <div class="progress-text">{{ $key == 0 ? 100 : round(($community->total_claims / $topCommunities[0]->total_claims) * 100) }}%</div>
                        </div>
                          <div class="leaderboard-score">
                            <i class="fa fa-handshake-o"></i> {{ number_format($community->total_claims, 0, ',', '.') }} Klaim
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="empty-state-text">Belum ada data komunitas untuk periode ini</div>
                    <a href="{{ route('register') }}" class="empty-state-action">
                        <i class="fa fa-plus-circle"></i> Daftar Sebagai Komunitas
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Info Section -->
    <div class="row mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s">
        <div class="col-md-12">
            <div class="info-card card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-question-circle mr-2"></i> Cara Meningkatkan Peringkat Anda</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-4">
                                <div class="info-icon">
                                    <i class="fa fa-gift fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold">Untuk Donatur</h5>
                                    <ul class="pl-3 mb-0">
                                        <li>Donasikan makanan secara aktif dan rutin</li>
                                        <li>Berikan makanan berkualitas dan aman</li>
                                        <li>Ajak restoran lain berpartisipasi</li>
                                        <li>Dapatkan badge khusus untuk kontributor terbaik</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-4">                                <div class="info-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                                    <i class="fa fa-handshake-o fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold">Untuk Penerima</h5>
                                    <ul class="pl-3 mb-0">
                                        <li>Klaim dan distribusikan makanan secara efisien</li>
                                        <li>Laporkan hasil distribusi dengan lengkap</li>
                                        <li>Berikan feedback tentang kualitas donasi</li>
                                        <li>Bagikan cerita positif dari penerima manfaat</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>                    <div class="alert alert-warning mt-3 mb-3">
                        <div class="d-flex">
                            <i class="fa fa-lightbulb-o mr-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Tip:</strong> Peringkat dihitung berdasarkan jumlah dan kualitas donasi yang dilakukan dalam satu bulan. Periode peringkat diperbarui setiap awal bulan.
                            </div>
                        </div>
                    </div>
                    
                    <div class="share-section">
                        <div class="mb-2"><strong>Bagikan Prestasi Anda:</strong></div>
                        <div class="share-buttons">
                            <a href="#" class="share-button share-facebook" onclick="shareOnFacebook()" title="Bagikan ke Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" class="share-button share-twitter" onclick="shareOnTwitter()" title="Bagikan ke Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#" class="share-button share-whatsapp" onclick="shareOnWhatsApp()" title="Bagikan ke WhatsApp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards - Additional Info -->
    <div class="row animate__animated animate__fadeInUp" style="animation-delay: 0.8s">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 mr-3 bg-transparent-success">
                            <i class="fa fa-leaf text-success"></i>
                        </div>
                        <h5 class="mb-0">Dampak Lingkungan</h5>
                    </div>
                    <p>Setiap donasi makanan mengurangi emisi karbon dari pembuangan makanan di TPA dan membantu pelestarian lingkungan.</p>
                    <div class="text-success font-weight-bold mt-2">
                        <i class="fa fa-check-circle"></i> Lebih dari {{ number_format($totalDonated * 2.5, 0, ',', '.') }} kg CO2 yang tidak dilepaskan ke atmosfer
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 mr-3 bg-transparent-info">
                            <i class="fa fa-users text-primary"></i>
                        </div>
                        <h5 class="mb-0">Dampak Sosial</h5>
                    </div>
                    <p>Program ini membantu komunitas yang membutuhkan dan menciptakan jaringan solidaritas sosial antar masyarakat.</p>
                    <div class="text-primary font-weight-bold mt-2">
                        <i class="fa fa-check-circle"></i> Telah membantu sekitar {{ number_format($totalDonated / 1.5, 0, ',', '.') }} individu
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 mr-3 bg-transparent-warning">
                            <i class="fa fa-calendar-check-o text-warning"></i>
                        </div>
                        <h5 class="mb-0">Jadwal Update Leaderboard</h5>
                    </div>
                    <p>Peringkat diperbarui secara otomatis setiap awal bulan. Kontributor terbaik akan mendapatkan penghargaan dan visibilitas khusus di platform.</p>
                    <div class="text-warning font-weight-bold mt-2">
                        <i class="fa fa-calendar"></i> Pembaruan berikutnya: {{ \Carbon\Carbon::now()->endOfMonth()->addDay()->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="{{ asset('assets/js/leaderboard.js') }}"></script>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Leaderboard Tab Switching Functionality
        const tabs = document.querySelectorAll('.leaderboard-tab');
        const donorsBoard = document.getElementById('leaderboard-donors');
        const communitiesBoard = document.getElementById('leaderboard-communities');
        const leaderboardTitle = document.querySelector('.leaderboard-title');
        
        // Set current date in the header
        const currentDateElement = document.getElementById('current-date');
        if (currentDateElement) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date();
            currentDateElement.textContent = today.toLocaleDateString('id-ID', options);
        }
        
        // Tab switching logic
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Visual tab switching
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Content switching with animation
                const type = this.getAttribute('data-type');
                if (type === 'donors') {                    donorsBoard.classList.add('animate__animated', 'animate__fadeIn');
                    donorsBoard.style.display = 'block';
                    communitiesBoard.style.display = 'none';
                    leaderboardTitle.innerHTML = '<i class="fa fa-star mr-2"></i> Top Donatur Bulan Ini';
                } else {
                    communitiesBoard.classList.add('animate__animated', 'animate__fadeIn');
                    donorsBoard.style.display = 'none';
                    communitiesBoard.style.display = 'block';
                    leaderboardTitle.innerHTML = '<i class="fa fa-star mr-2"></i> Top Penerima Bulan Ini';
                }
                
                // Add staggered animation to items
                const items = document.querySelectorAll('.leaderboard-item');
                items.forEach((item, index) => {
                    item.classList.remove('slide-in');
                    void item.offsetWidth; // Trigger reflow
                    item.classList.add('slide-in');
                    item.style.animationDelay = (index * 0.1) + 0.1 + 's';
                });
            });
        });
        
        // Initial animation for items
        setTimeout(() => {
            const items = document.querySelectorAll('.leaderboard-body:not([style*="display: none"]) .leaderboard-item');
            items.forEach((item, index) => {
                item.classList.add('slide-in');
                item.style.animationDelay = (index * 0.1) + 0.1 + 's';
            });
        }, 500);
        
        // Hover effects for better interactivity
        const leaderboardItems = document.querySelectorAll('.leaderboard-item');
        leaderboardItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(10px)';
                this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endpush
