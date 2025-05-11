@extends('layouts.admin.master')

@section('title', 'Dashboard - No Food Waste')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg) var(--spacing-xl);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--spacing-xl);
    }
    
    .page-header h3 {
        color: white;
        font-weight: 700;
        margin-bottom: var(--spacing-sm);
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    
    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
    }
    
    .breadcrumb-item.active {
        color: white;
    }
    
    .dashboard-welcome-banner {
        background: linear-gradient(to right, var(--primary-light), var(--primary));
        border-radius: var(--radius-lg);
        padding: var(--spacing-xl);
        margin-bottom: var(--spacing-xl);
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: var(--shadow-md);
    }
    
    .dashboard-welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: url('{{ asset('assets/images/pattern-dots.svg') }}') repeat;
        opacity: 0.1;
        transform: rotate(30deg);
    }
    
    .dashboard-welcome-content {
        position: relative;
        z-index: 1;
    }
    
    .dashboard-welcome-title {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        margin-bottom: var(--spacing-sm);
    }
    
    .dashboard-welcome-text {
        font-size: var(--font-size-base);
        opacity: 0.9;
        margin-bottom: var(--spacing-lg);
        max-width: 600px;
    }
    
    .dashboard-overview {
        margin-bottom: var(--spacing-xl);
    }
    
    .dashboard-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }
    
    .stat-card {
        background-color: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .stat-header {
        padding: var(--spacing-md);
        border-bottom: 1px solid var(--neutral-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-title {
        font-size: var(--font-size-sm);
        font-weight: 600;
        color: var(--neutral-700);
        margin: 0;
    }
    
    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .stat-icon.food {
        background-color: rgba(44, 107, 47, 0.1);
        color: var(--primary);
    }
    
    .stat-icon.users {
        background-color: rgba(247, 148, 29, 0.1);
        color: var(--accent);
    }
    
    .stat-icon.donations {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    
    .stat-icon.communities {
        background-color: rgba(108, 117, 125, 0.1);
        color: var(--neutral-700);
    }
    
    .stat-body {
        padding: var(--spacing-md);
    }
    
    .stat-value {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        margin-bottom: var(--spacing-xs);
        display: flex;
        align-items: baseline;
    }
    
    .stat-unit {
        font-size: var(--font-size-sm);
        font-weight: 400;
        color: var(--neutral-600);
        margin-left: var(--spacing-xs);
    }
    
    .stat-change {
        display: flex;
        align-items: center;
        font-size: var(--font-size-sm);
    }
    
    .stat-change.positive {
        color: var(--success);
    }
    
    .stat-change.negative {
        color: var(--danger);
    }
    
    .stat-period {
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
    }
    
    .dashboard-charts {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-xl);
    }
    
    .chart-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }
    
    .chart-header {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid var(--neutral-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .chart-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        color: var(--neutral-800);
        margin: 0;
    }
    
    .chart-actions {
        display: flex;
        gap: var(--spacing-sm);
    }
    
    .chart-action-btn {
        background: var(--neutral-100);
        border: none;
        border-radius: var(--radius-sm);
        padding: 0.3rem 0.6rem;
        font-size: var(--font-size-sm);
        color: var(--neutral-700);
        cursor: pointer;
        transition: var(--transition-fast);
    }
    
    .chart-action-btn:hover {
        background: var(--neutral-200);
    }
    
    .chart-action-btn.active {
        background: var(--primary);
        color: white;
    }
    
    .chart-body {
        padding: var(--spacing-lg);
    }
    
    .donation-map {
        height: 300px;
        border-radius: var(--radius-md);
        overflow: hidden;
    }
    
    .leaderboard-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        margin-bottom: var(--spacing-xl);
    }
    
    .leaderboard-header {
        background: linear-gradient(to right, var(--accent), var(--accent-dark));
        color: white;
        padding: var(--spacing-md) var(--spacing-lg);
        border-top-left-radius: var(--radius-lg);
        border-top-right-radius: var(--radius-lg);
    }
    
    .leaderboard-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin: 0;
    }
    
    .leaderboard-tabs {
        display: flex;
        background: var(--neutral-100);
        padding: var(--spacing-sm);
        border-bottom: 1px solid var(--neutral-200);
    }
    
    .leaderboard-tab {
        padding: var(--spacing-sm) var(--spacing-md);
        font-size: var(--font-size-sm);
        font-weight: 500;
        color: var(--neutral-700);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition-fast);
    }
    
    .leaderboard-tab:hover {
        background: var(--neutral-200);
    }
    
    .leaderboard-tab.active {
        background: var(--primary);
        color: white;
    }
    
    .leaderboard-body {
        padding: var(--spacing-md);
    }
    
    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: var(--spacing-md);
        border-bottom: 1px solid var(--neutral-200);
        transition: var(--transition-fast);
    }
    
    .leaderboard-item:last-child {
        border-bottom: none;
    }
    
    .leaderboard-item:hover {
        background: var(--neutral-100);
    }
    
    .leaderboard-rank {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--neutral-200);
        border-radius: var(--radius-full);
        margin-right: var(--spacing-md);
        font-weight: 600;
        color: var(--neutral-700);
    }
    
    .leaderboard-rank.top {
        background: var(--accent);
        color: white;
    }
    
    .leaderboard-user {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .leaderboard-avatar {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-full);
        background: var(--neutral-300);
        margin-right: var(--spacing-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral-700);
        font-weight: 600;
        font-size: var(--font-size-sm);
    }
    
    .leaderboard-user-info {
        flex: 1;
    }
    
    .leaderboard-name {
        font-weight: 600;
        margin-bottom: 0.2rem;
        color: var(--neutral-800);
    }
    
    .leaderboard-role {
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
    }
    
    .leaderboard-score {
        font-weight: 700;
        color: var(--primary);
    }
    
    .recent-donations {
        margin-bottom: var(--spacing-xl);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-lg);
    }
    
    .section-title {
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--neutral-800);
        margin: 0;
    }
    
    .section-action {
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    
    .section-action i {
        margin-left: var(--spacing-xs);
    }
    
    .section-action:hover {
        text-decoration: underline;
    }
    
    .donations-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--spacing-lg);
    }
    
    .donation-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
    }
    
    .donation-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .donation-image {
        height: 200px;
        position: relative;
    }
    
    .donation-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .donation-status {
        position: absolute;
        top: var(--spacing-sm);
        right: var(--spacing-sm);
        padding: 0.2rem 0.6rem;
        font-size: var(--font-size-sm);
        font-weight: 500;
        border-radius: var(--radius-full);
        background: white;
        box-shadow: var(--shadow-sm);
    }
    
    .donation-status.available {
        background: var(--success);
        color: white;
    }
    
    .donation-status.claimed {
        background: var(--accent);
        color: white;
    }
    
    .donation-status.expired {
        background: var(--danger);
        color: white;
    }
    
    .donation-body {
        padding: var(--spacing-lg);
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .donation-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        color: var(--neutral-800);
        margin-bottom: var(--spacing-sm);
    }
    
    .donation-meta {
        display: flex;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        color: var(--neutral-600);
        font-size: var(--font-size-sm);
    }
    
    .donation-meta-item {
        display: flex;
        align-items: center;
    }
    
    .donation-meta-item i {
        margin-right: var(--spacing-xs);
    }
    
    .donation-description {
        margin-bottom: var(--spacing-md);
        color: var(--neutral-700);
        flex: 1;
    }
    
    .donation-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .donation-donor {
        display: flex;
        align-items: center;
    }
    
    .donation-donor-avatar {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-full);
        margin-right: var(--spacing-xs);
    }
    
    .donation-donor-name {
        font-size: var(--font-size-sm);
        font-weight: 500;
        color: var(--neutral-700);
    }
    
    .donation-action {
        font-size: var(--font-size-sm);
        font-weight: 500;
        color: var(--primary);
        text-decoration: none;
    }
    
    .donation-action:hover {
        text-decoration: underline;
    }
    
    .quick-actions {
        margin-bottom: var(--spacing-xl);
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--spacing-md);
    }
    
    .quick-action-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        text-align: center;
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
        cursor: pointer;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .quick-action-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-full);
        background: var(--neutral-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--spacing-md);
        font-size: 1.5rem;
    }
    
    .quick-action-icon.donate {
        color: var(--primary);
        background: rgba(44, 107, 47, 0.1);
    }
    
    .quick-action-icon.find {
        color: var(--accent);
        background: rgba(247, 148, 29, 0.1);
    }
    
    .quick-action-icon.leaderboard {
        color: #0d6efd;
        background: rgba(13, 110, 253, 0.1);
    }
    
    .quick-action-icon.profile {
        color: var(--neutral-700);
        background: rgba(108, 117, 125, 0.1);
    }
    
    .quick-action-title {
        font-weight: 600;
        margin-bottom: var(--spacing-xs);
        color: var(--neutral-800);
    }
    
    .quick-action-description {
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
    }
    
    .swiper {
        width: 100%;
        height: 300px;
        margin-bottom: var(--spacing-xl);
    }
    
    .swiper-slide {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }
    
    .testimonial {
        display: flex;
        height: 100%;
    }
    
    .testimonial-image {
        width: 40%;
        position: relative;
    }
    
    .testimonial-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .testimonial-content {
        width: 60%;
        padding: var(--spacing-xl);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .testimonial-text {
        font-size: var(--font-size-lg);
        line-height: 1.5;
        margin-bottom: var(--spacing-md);
        color: var(--neutral-800);
        font-style: italic;
        position: relative;
    }
    
    .testimonial-text::before {
        content: '"';
        position: absolute;
        top: -20px;
        left: -10px;
        font-size: 3rem;
        color: var(--neutral-300);
        font-family: serif;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
    }
    
    .testimonial-author-avatar {
        width: 48px;
        height: 48px;
        border-radius: var (--radius-full);
        margin-right: var(--spacing-md);
    }
    
    .testimonial-author-info h4 {
        margin: 0;
        font-weight: 600;
        color: var(--neutral-800);
    }
    
    .testimonial-author-info p {
        margin: 0;
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
    }
    
    .swiper-pagination-bullet-active {
        background: var(--primary);
    }
    
    .swiper-button-prev, .swiper-button-next {
        color: var(--primary);
    }
    
    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .dashboard-stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .dashboard-charts {
            grid-template-columns: 1fr;
        }
        
        .donations-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .donations-grid {
            grid-template-columns: 1fr;
        }
        
        .testimonial {
            flex-direction: column;
        }
        
        .testimonial-image, .testimonial-content {
            width: 100%;
        }
        
        .testimonial-image {
            height: 200px;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-stat-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="page-header-left">
                    <h3>Dashboard</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end">
                    <!-- User Profile Dropdown -->
                    <div class="dropdown">                        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->username ?? 'Pengguna' }}
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
                </div>
            </div>
        </div>
    </div>
    
    <!-- Welcome Banner -->
    <div class="dashboard-welcome-banner">
        <div class="dashboard-welcome-content">
            <h2 class="dashboard-welcome-title">Selamat Datang, {{ Auth::user()->username ?? 'Pengguna' }}!</h2>
            <p class="dashboard-welcome-text">
                Hari ini adalah hari yang tepat untuk berbagi kebaikan. Mari kita perkuat komitmen untuk mengurangi pemborosan makanan dan membantu mereka yang membutuhkan.
            </p>
            <div class="d-flex gap-2">
                <a href="{{ route('donate') }}" class="btn btn-light">
                    <i class="fas fa-hand-holding-heart me-2"></i>Donasi Makanan
                </a>
                <a href="{{ route('find-donations') }}" class="btn btn-outline-light">
                    <i class="fas fa-search me-2"></i>Cari Donasi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="dashboard-overview">
        <div class="dashboard-stat-grid">
            <!-- Food Saved -->
            <div class="stat-card">
                <div class="stat-header">
                    <h5 class="stat-title">Makanan Terselamatkan</h5>
                    <div class="stat-icon food">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        750<span class="stat-unit">Kg</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>15.3%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Active Users -->
            <div class="stat-card">
                <div class="stat-header">
                    <h5 class="stat-title">Pengguna Aktif</h5>
                    <div class="stat-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        325<span class="stat-unit">Pengguna</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>8.7%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Successful Donations -->
            <div class="stat-card">
                <div class="stat-header">
                    <h5 class="stat-title">Donasi Berhasil</h5>
                    <div class="stat-icon donations">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        128<span class="stat-unit">Donasi</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>23.5%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
            
            <!-- Communities Helped -->
            <div class="stat-card">
                <div class="stat-header">
                    <h5 class="stat-title">Komunitas Terbantu</h5>
                    <div class="stat-icon communities">
                        <i class="fas fa-place-of-worship"></i>
                    </div>
                </div>
                <div class="stat-body">
                    <div class="stat-value">
                        42<span class="stat-unit">Komunitas</span>
                    </div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up me-1"></i>4.2%
                        <span class="stat-period ms-2">vs. bulan lalu</span>
                    </div>
                </div>
            </div>
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
                </div>
            </div>
            <div class="chart-body">
                <div id="donationMap" class="donation-map"></div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="section-header">
            <h3 class="section-title">Aksi Cepat</h3>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('donate') }}" class="quick-action-card">
                <div class="quick-action-icon donate">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h4 class="quick-action-title">Donasi Makanan</h4>
                <p class="quick-action-description">Bagikan makanan berlebih kepada yang membutuhkan</p>
            </a>
            
            <a href="{{ route('find-donations') }}" class="quick-action-card">
                <div class="quick-action-icon find">
                    <i class="fas fa-search"></i>
                </div>
                <h4 class="quick-action-title">Cari Donasi</h4>
                <p class="quick-action-description">Temukan donasi makanan di sekitar lokasi Anda</p>
            </a>
            
            <a href="#" class="quick-action-card">
                <div class="quick-action-icon leaderboard">
                    <i class="fas fa-trophy"></i>
                </div>
                <h4 class="quick-action-title">Leaderboard</h4>
                <p class="quick-action-description">Lihat peringkat donatur terbaik bulan ini</p>
            </a>
            
            <a href="#" class="quick-action-card">
                <div class="quick-action-icon profile">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h4 class="quick-action-title">Edit Profil</h4>
                <p class="quick-action-description">Perbarui informasi dan preferensi akun Anda</p>
            </a>
        </div>
    </div>
    
    <!-- Recent Donations -->
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
    </div>
    
    <!-- Leaderboard -->
    <div class="leaderboard-card">
        <div class="leaderboard-header">
            <h3 class="leaderboard-title">Top Donatur Bulan Ini</h3>
        </div>
        <div class="leaderboard-tabs">
            <div class="leaderboard-tab active">Donatur</div>
            <div class="leaderboard-tab">Komunitas</div>
        </div>
        <div class="leaderboard-body">
            <!-- Leaderboard Item 1 -->
            <div class="leaderboard-item">
                <div class="leaderboard-rank top">1</div>
                <div class="leaderboard-user">
                    <div class="leaderboard-avatar" style="background-image: url('{{ asset('assets/images/user1.jpg') }}'); background-size: cover;"></div>
                    <div class="leaderboard-user-info">
                        <div class="leaderboard-name">PT Seminar Indonesia</div>
                        <div class="leaderboard-role">Perusahaan</div>
                    </div>
                </div>
                <div class="leaderboard-score">120 Kg</div>
            </div>
            
            <!-- Leaderboard Item 2 -->
            <div class="leaderboard-item">
                <div class="leaderboard-rank top">2</div>
                <div class="leaderboard-user">
                    <div class="leaderboard-avatar" style="background-image: url('{{ asset('assets/images/user2.jpg') }}'); background-size: cover;"></div>
                    <div class="leaderboard-user-info">
                        <div class="leaderboard-name">Bakery Delicious</div>
                        <div class="leaderboard-role">Toko Roti</div>
                    </div>
                </div>
                <div class="leaderboard-score">85 Kg</div>
            </div>
            
            <!-- Leaderboard Item 3 -->
            <div class="leaderboard-item">
                <div class="leaderboard-rank top">3</div>
                <div class="leaderboard-user">
                    <div class="leaderboard-avatar" style="background-image: url('{{ asset('assets/images/user3.jpg') }}'); background-size: cover;"></div>
                    <div class="leaderboard-user-info">
                        <div class="leaderboard-name">Kebun Sayur Bahagia</div>
                        <div class="leaderboard-role">Petani</div>
                    </div>
                </div>
                <div class="leaderboard-score">64 Kg</div>
            </div>
            
            <!-- Leaderboard Item 4 -->
            <div class="leaderboard-item">
                <div class="leaderboard-rank">4</div>
                <div class="leaderboard-user">
                    <div class="leaderboard-avatar">
                        AR
                    </div>
                    <div class="leaderboard-user-info">
                        <div class="leaderboard-name">Andi Resto</div>
                        <div class="leaderboard-role">Rumah Makan</div>
                    </div>
                </div>
                <div class="leaderboard-score">52 Kg</div>
            </div>
            
            <!-- Leaderboard Item 5 -->
            <div class="leaderboard-item">
                <div class="leaderboard-rank">5</div>
                <div class="leaderboard-user">
                    <div class="leaderboard-avatar">
                        HM
                    </div>
                    <div class="leaderboard-user-info">
                        <div class="leaderboard-name">Hotel Mewah</div>
                        <div class="leaderboard-role">Hotel</div>
                    </div>
                </div>
                <div class="leaderboard-score">45 Kg</div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials Slider -->
    <div class="section-header">
        <h3 class="section-title">Kisah Inspiratif</h3>
    </div>
    
    <div class="swiper testimonial-slider">
        <div class="swiper-wrapper">
            <!-- Testimonial 1 -->
            <div class="swiper-slide">
                <div class="testimonial">
                    <div class="testimonial-image">
                        <img src="{{ asset('assets/images/testimonial1.jpg') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            Platform No Food Waste telah membantu kami menyalurkan makanan berlebih dari restoran kami kepada yang membutuhkan. Sangat mudah digunakan dan dampaknya luar biasa.
                        </p>
                        <div class="testimonial-author">
                            <img src="{{ asset('assets/images/user1.jpg') }}" alt="Author" class="testimonial-author-avatar">
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
                        <img src="{{ asset('assets/images/testimonial2.jpg') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            Sebagai pengelola panti asuhan, kami sangat terbantu dengan donasi makanan melalui platform ini. Anak-anak selalu senang mendapatkan makanan bergizi yang beragam.
                        </p>
                        <div class="testimonial-author">
                            <img src="{{ asset('assets/images/user2.jpg') }}" alt="Author" class="testimonial-author-avatar">
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
                        <img src="{{ asset('assets/images/testimonial3.jpg') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            Setelah bergabung dengan komunitas No Food Waste, saya merasa lebih bermakna. Kini, makanan berlebih di toko kami tidak terbuang sia-sia, melainkan membantu sesama.
                        </p>
                        <div class="testimonial-author">
                            <img src="{{ asset('assets/images/user3.jpg') }}" alt="Author" class="testimonial-author-avatar">
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
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Donation Trends Chart
        const ctx = document.getElementById('donationTrendsChart').getContext('2d');
        
        const donationTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Donasi (Kg)',
                        data: [65, 78, 52, 91, 43, 56, 61, 87, 75, 62, 45, 92],
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
                        label: 'Klaim (Kg)',
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
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
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
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
        
        // Chart Period Buttons
        $('.chart-action-btn').click(function() {
            $('.chart-action-btn').removeClass('active');
            $(this).addClass('active');
            
            const period = $(this).data('period');
            let newData, newLabels;
            
            if (period === 'monthly') {
                newLabels = ['1 Mei', '5 Mei', '10 Mei', '15 Mei', '20 Mei', '25 Mei', '30 Mei'];
                newData = [
                    {
                        label: 'Donasi (Kg)',
                        data: [12, 19, 8, 15, 10, 14, 18],
                        borderColor: '#2C6B2F',
                        backgroundColor: 'rgba(44, 107, 47, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Klaim (Kg)',
                        data: [8, 15, 6, 12, 9, 12, 15],
                        borderColor: '#F7941D',
                        backgroundColor: 'rgba(247, 148, 29, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ];
            } else if (period === 'quarterly') {
                newLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];
                newData = [
                    {
                        label: 'Donasi (Kg)',
                        data: [65, 78, 52, 91, 43],
                        borderColor: '#2C6B2F',
                        backgroundColor: 'rgba(44, 107, 47, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Klaim (Kg)',
                        data: [30, 45, 22, 81, 35],
                        borderColor: '#F7941D',
                        backgroundColor: 'rgba(247, 148, 29, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ];
            } else if (period === 'yearly') {
                newLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                newData = [
                    {
                        label: 'Donasi (Kg)',
                        data: [65, 78, 52, 91, 43, 56, 61, 87, 75, 62, 45, 92],
                        borderColor: '#2C6B2F',
                        backgroundColor: 'rgba(44, 107, 47, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Klaim (Kg)',
                        data: [30, 45, 22, 81, 35, 53, 59, 79, 60, 52, 38, 85],
                        borderColor: '#F7941D',
                        backgroundColor: 'rgba(247, 148, 29, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ];
            }
            
            donationTrendsChart.data.labels = newLabels;
            donationTrendsChart.data.datasets = newData;
            donationTrendsChart.update();
        });
        
        // Leaderboard Tabs
        $('.leaderboard-tab').click(function() {
            $('.leaderboard-tab').removeClass('active');
            $(this).addClass('active');
        });
        
        // Testimonial Slider
        const swiper = new Swiper('.testimonial-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
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
    
    // Initialize Map
    let map;
    
    function initMap() {
        map = L.map('donationMap').setView([-6.200000, 106.816666], 13); // Jakarta coordinates
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Custom marker icon
        const foodIcon = L.icon({
            iconUrl: '{{ asset('assets/images/food-marker.png') }}',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });
        
        // Add sample markers
        addMarker(-6.1754, 106.8272, 'Nasi Kotak Sisa Event', '25 Porsi', 'PT Seminar Indonesia', foodIcon);
        addMarker(-6.2088, 106.8456, 'Aneka Roti dan Kue', '15 Item', 'Bakery Delicious', foodIcon);
        addMarker(-6.1899, 106.8219, 'Sayuran Organik Segar', '8 Kg', 'Kebun Sayur Bahagia', foodIcon);
        addMarker(-6.1744, 106.7900, 'Buah-buahan Segar', '12 Kg', 'Toko Buah Sehat', foodIcon);
        addMarker(-6.2156, 106.8063, 'Menu Catering Sisa', '18 Porsi', 'Catering Lezat', foodIcon);
    }
    
    function addMarker(lat, lng, title, quantity, donor, icon) {
        const marker = L.marker([lat, lng], {icon: icon}).addTo(map);
        marker.bindPopup(`
            <div style="width: 200px;">
                <strong>${title}</strong><br>
                <span style="color: #2C6B2F;">${quantity}</span><br>
                <small>Oleh: ${donor}</small><br>
                <a href="#" style="color: #2C6B2F; text-decoration: none; font-weight: 500; display: inline-block; margin-top: 8px;">Lihat Detail</a>
            </div>
        `);
    }
    
    function resetMap() {
        map.setView([-6.200000, 106.816666], 13);
    }
    
    // Initialize map when the page is loaded
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initMap, 500); // Delay to ensure the container is ready
    });
</script>
@endpush
