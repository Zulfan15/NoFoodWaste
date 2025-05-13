<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NoFoodWaste - Kurangi Pemborosan Makanan</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
    
    <style>
        body {
            font-family: var(--font-primary);
            margin: 0;
            padding: 0;
        }
        
        /* Floating CTA */
        .floating-cta {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: var(--z-fixed);
            animation: pulse 2s infinite;
        }
        
        /* Badges for donation cards */
        .badge-urgent {
            background-color: var(--danger);
            color: white;
            padding: 3px 8px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            position: absolute;
            top: 15px;
            right: 15px;
        }
        
        /* Testimonial styles */
        .testimonial-card {
            background-color: white;
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }
        
        .testimonial-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: var(--spacing-md);
        }
        
        .testimonial-content {
            font-style: italic;
            margin-bottom: var(--spacing-md);
            color: var(--neutral-700);
            position: relative;
            padding: 0 var(--spacing-md);
        }
        
        .testimonial-content:before {
            content: '"';
            font-size: 60px;
            font-family: Georgia, serif;
            color: var(--primary-light);
            opacity: 0.3;
            position: absolute;
            left: -15px;
            top: -30px;
        }
        
        /* Gallery styles */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--spacing-md);
        }
        
        .gallery-item {
            height: 200px;
            border-radius: var(--radius-md);
            overflow: hidden;
            position: relative;
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-normal);
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(44, 107, 47, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition-normal);
        }
        
        .gallery-caption {
            color: white;
            text-align: center;
            padding: var(--spacing-md);
        }
        
        /* FAQ styles */
        .faq-item {
            border-bottom: 1px solid var(--neutral-300);
            margin-bottom: var(--spacing-md);
        }
        
        .faq-question {
            font-weight: 600;
            color: var(--primary-dark);
            padding: var(--spacing-md) 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-answer {
            padding-bottom: var(--spacing-md);
            color: var(--neutral-700);
            display: none;
        }
        
        .faq-active .faq-answer {
            display: block;
        }
        
        /* Counter animation */
        .counter-animation {
            transition: all 2s ease-in-out;
        }
        
        /* Stats cards enhancements */
        .stat-card {
            overflow: visible;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 20px;
            right: 20px;
            height: 10px;
            background-color: var(--primary);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }
        
        /* Donation card styles */
        .donation-slider {
            overflow-x: auto;
            display: flex;
            gap: var(--spacing-md);
            padding: var(--spacing-md) 0;
            scrollbar-width: thin;
        }
        
        .donation-card {
            min-width: 280px;
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            flex: 0 0 auto;
            position: relative;
            transition: var(--transition-normal);
        }
        
        .donation-card:hover {
            transform: translateY(-10px);
            box-shadow: var (--shadow-lg);
        }
        
        .donation-img {
            height: 150px;
            width: 100%;
            object-fit: cover;
        }
        
        .donation-body {
            padding: var(--spacing-md);
        }
        
        .donation-title {
            font-weight: 600;
            margin-bottom: var(--spacing-xs);
        }
        
        .donation-meta {
            display: flex;
            justify-content: space-between;
            color: var(--neutral-600);
            font-size: 14px;
            margin-bottom: var(--spacing-sm);
        }
        
        .donation-footer {
            padding: var(--spacing-sm);
            border-top: 1px solid var(--neutral-300);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        @media (max-width: 992px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="NoFoodWaste Logo">
                <span>NO FOOD WASTE</span>
            </a>
            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="navbar-nav" id="navbarMenu">
                <li class="nav-item">
                    <a href="#about" class="nav-link">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a href="#donations" class="nav-link">Donasi</a>
                </li>
                <li class="nav-item">
                    <a href="#statistics" class="nav-link">Statistik</a>
                </li>
                <li class="nav-item">
                    <a href="#testimonials" class="nav-link">Testimoni</a>
                </li>
                <li class="nav-item">
                    <a href="#guide" class="nav-link">Petunjuk</a>
                </li>
                <li class="nav-item">
                    <a href="#faq" class="nav-link">FAQ</a>
                </li>
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link p-0">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <!-- Hero Section with animated texts -->
    <section class="hero">
        <div class="container">
            <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="hero-title">Bersama Kita Bisa Mengurangi Pemborosan Makanan dan Menjaga Bumi!</h1>
                <p class="hero-subtitle">Setiap tindakan kita bisa mengurangi sampah makanan dan menjaga bumi untuk generasi mendatang</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-accent btn-lg">GABUNG SEKARANG</a>
                    <a href="#about" class="btn btn-outline-primary btn-lg">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem Highlight Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-primary font-weight-bold mb-4">Permasalahan Pemborosan Makanan</h2>
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-card-icon text-danger mr-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">1/3 Makanan Terbuang</h3>
                            <p class="text-muted">Sepertiga makanan yang diproduksi di dunia terbuang sia-sia.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-card-icon text-danger mr-3">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">8% Emisi Gas Rumah Kaca</h3>
                            <p class="text-muted">Pemborosan makanan menyumbang 8% emisi gas rumah kaca global.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-card-icon text-danger mr-3">
                            <i class="fas fa-water"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">Pemborosan Air</h3>
                            <p class="text-muted">Jumlah air yang hilang akibat pemborosan makanan setara dengan kebutuhan 9 miliar orang.</p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="d-flex justify-content-center align-items-center h-100" style="min-height:400px;">
                        <img src="{{ asset('assets/images/foodwaste.png') }}" alt="Permasalahan Pemborosan Makanan" class="w-100 rounded-lg" style="object-fit:contain; height:400px; background:#f5f5f5; display:block; max-width:100%; max-width:400px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="about">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Tentang NoFoodWaste</h2>
                <p class="section-subtitle">Inisiatif untuk mengurangi pemborosan makanan dan menciptakan masa depan yang lebih berkelanjutan</p>
            </div>
            <div class="features-grid">
                <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3 class="feature-title">Kurangi Pemborosan</h3>
                    <p class="feature-description">Mengurangi jumlah makanan yang terbuang dalam rantai pasokan dan konsumsi sehari-hari.</p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="feature-title">Donasi Makanan</h3>
                    <p class="feature-description">Menghubungkan donator dengan penerima yang membutuhkan makanan layak konsumsi.</p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="feature-title">Dampak Lingkungan</h3>
                    <p class="feature-description">Mengurangi emisi gas rumah kaca dengan mencegah pembusukan makanan di tempat pembuangan.</p>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                <p class="mb-4">NoFoodWaste adalah platform yang menghubungkan donatur makanan dengan penerima yang membutuhkan, membantu mengurangi pemborosan makanan dan memerangi kelaparan. Dengan pendekatan berbasis teknologi, kami membuat donasi makanan menjadi lebih efisien dan efektif.</p>
                <a href="#guide" class="btn btn-primary">Pelajari Cara Kerjanya</a>
            </div>
        </div>
    </section>
    
    <!-- Recent Donations Section -->
    <section class="bg-white py-5" id="donations">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Donasi Makanan Terbaru</h2>
                <p class="section-subtitle">Makanan berkualitas yang tersedia untuk didonasikan hari ini</p>
            </div>
            
            <div class="donation-slider" data-aos="fade-up" data-aos-delay="100">
                <div class="donation-card">
                    <span class="badge-urgent">Mendesak</span>
                    <img src="{{ asset('assets/images/donation1.jpg') }}" alt="Donasi Makanan" class="donation-img">
                    <div class="donation-body">
                        <h4 class="donation-title">Roti & Pastry Segar</h4>
                        <div class="donation-meta">
                            <span><i class="far fa-clock mr-1"></i> Exp: Hari Ini</span>
                            <span><i class="fas fa-box mr-1"></i> 5 kg</span>
                        </div>
                        <p>Roti dan pastry segar dari toko roti yang belum terjual hari ini.</p>
                    </div>
                    <div class="donation-footer">
                        <div class="donor-badge">
                            <img src="{{ asset('assets/images/donor1.jpg') }}" alt="Donor">
                            <span>Bakery Nusantara</span>
                        </div>
                        <a href="#" class="btn btn-sm btn-primary">Klaim</a>
                    </div>
                </div>
                
                <div class="donation-card">
                    <img src="{{ asset('assets/images/donation2.jpg') }}" alt="Donasi Makanan" class="donation-img">
                    <div class="donation-body">
                        <h4 class="donation-title">Sayuran Organik</h4>
                        <div class="donation-meta">
                            <span><i class="far fa-clock mr-1"></i> Exp: 3 Hari</span>
                            <span><i class="fas fa-box mr-1"></i> 8 kg</span>
                        </div>
                        <p>Sayuran organik segar dari panen kebun komunitas.</p>
                    </div>
                    <div class="donation-footer">
                        <div class="donor-badge">
                            <img src="{{ asset('assets/images/donor2.jpg') }}" alt="Donor">
                            <span>Kebun Sehat</span>
                        </div>
                        <a href="#" class="btn btn-sm btn-primary">Klaim</a>
                    </div>
                </div>
                
                <div class="donation-card">
                    <img src="{{ asset('assets/images/donation3.jpg') }}" alt="Donasi Makanan" class="donation-img">
                    <div class="donation-body">
                        <h4 class="donation-title">Makanan Siap Saji</h4>
                        <div class="donation-meta">
                            <span><i class="far fa-clock mr-1"></i> Exp: Hari Ini</span>
                            <span><i class="fas fa-box mr-1"></i> 10 porsi</span>
                        </div>
                        <p>Nasi kotak dan lauk pauk dari sisa catering pertemuan.</p>
                    </div>
                    <div class="donation-footer">
                        <div class="donor-badge">
                            <img src="{{ asset('assets/images/donor3.jpg') }}" alt="Donor">
                            <span>Catering Bahagia</span>
                        </div>
                        <a href="#" class="btn btn-sm btn-primary">Klaim</a>
                    </div>
                </div>
                
                <div class="donation-card">
                    <img src="{{ asset('assets/images/donation4.jpg') }}" alt="Donasi Makanan" class="donation-img">
                    <div class="donation-body">
                        <h4 class="donation-title">Buah Segar</h4>
                        <div class="donation-meta">
                            <span><i class="far fa-clock mr-1"></i> Exp: 5 Hari</span>
                            <span><i class="fas fa-box mr-1"></i> 12 kg</span>
                        </div>
                        <p>Bermacam buah segar dari supermarket lokal yang masih berkualitas baik.</p>
                    </div>
                    <div class="donation-footer">
                        <div class="donor-badge">
                            <img src="{{ asset('assets/images/donor4.jpg') }}" alt="Donor">
                            <span>Fresh Market</span>
                        </div>
                        <a href="#" class="btn btn-sm btn-primary">Klaim</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="#" class="btn btn-outline-primary">Lihat Semua Donasi <i class="fas fa-arrow-right ml-2"></i></a>
            </div>
        </div>
    </section>

    <!-- Statistics Section with animated counters -->
    <section class="bg-secondary py-5" id="statistics">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Statistik Dampak</h2>
                <p class="section-subtitle">Lihat bagaimana kontribusi kita bersama telah membuat perubahan</p>
            </div>
            <div class="row">
                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card bg-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon text-primary">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="stat-card-value counter-animation" data-count="5372">0</div>
                            <div class="stat-card-label">Makanan Diselamatkan (kg)</div>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card bg-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon text-accent">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-card-value counter-animation" data-count="1254">0</div>
                            <div class="stat-card-label">Orang Terbantu</div>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card bg-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon text-success">
                                <i class="fas fa-tree"></i>
                            </div>
                            <div class="stat-card-value counter-animation" data-count="2185">0</div>
                            <div class="stat-card-label">Emisi CO² Dikurangi (kg)</div>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card bg-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon text-info">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="stat-card-value counter-animation" data-count="487">0</div>
                            <div class="stat-card-label">Donasi Berhasil</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-white" id="testimonials">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Kisah Sukses</h2>
                <p class="section-subtitle">Bagaimana NoFoodWaste membantu orang dan lingkungan</p>
            </div>
            
            <div class="row">
                <div class="col" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Testimonial" class="testimonial-avatar">
                            <div>
                                <h4 class="mb-0">Budi Santoso</h4>
                                <p class="text-muted mb-0">Pemilik Restoran</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            "Sebelumnya saya selalu merasa bersalah membuang makanan sisa di restoran saya. Dengan NoFoodWaste, saya bisa menyumbangkan makanan tersebut kepada yang membutuhkan. Ini solusi yang sangat baik untuk bisnis saya dan lingkungan."
                        </div>
                        <div class="text-right">
                            <div class="text-primary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Testimonial" class="testimonial-avatar">
                            <div>
                                <h4 class="mb-0">Siti Rahma</h4>
                                <p class="text-muted mb-0">Pengelola Panti Asuhan</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            "NoFoodWaste telah sangat membantu panti asuhan kami mendapatkan makanan bergizi untuk anak-anak. Kami menerima donasi makanan berkualitas baik secara rutin, yang sangat membantu mengurangi biaya operasional kami."
                        </div>
                        <div class="text-right">
                            <div class="text-primary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Testimonial" class="testimonial-avatar">
                            <div>
                                <h4 class="mb-0">Anita Wijaya</h4>
                                <p class="text-muted mb-0">Aktivis Lingkungan</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            "Sebagai aktivis lingkungan, saya sangat mengapresiasi apa yang dilakukan NoFoodWaste. Platform ini membantu mengurangi pemborosan makanan secara signifikan dan dampaknya pada lingkungan sangat nyata. Ini adalah contoh bagaimana teknologi bisa membantu masalah sosial."
                        </div>
                        <div class="text-right">
                            <div class="text-primary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col" data-aos="fade-up" data-aos-delay="400">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/usericon.png') }}" alt="Testimonial" class="testimonial-avatar">
                            <div>
                                <h4 class="mb-0">Rudi Hartono</h4>
                                <p class="text-muted mb-0">Manajer Supermarket</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            "NoFoodWaste membantu supermarket kami mendonasikan makanan yang mendekati tanggal kedaluwarsa tapi masih sangat layak dikonsumsi. Prosesnya sangat mudah dan cepat. Kami senang bisa berkontribusi pada pengurangan sampah makanan dan membantu komunitas."
                        </div>
                        <div class="text-right">
                            <div class="text-primary">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-5 bg-light" id="gallery">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Galeri Aktivitas</h2>
                <p class="section-subtitle">Melihat bagaimana NoFoodWaste beraksi di lapangan</p>
            </div>
            
            <div class="gallery-grid">
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('assets/images/gallery1.jpg') }}" alt="Gallery Item">
                    <div class="gallery-overlay">
                        <div class="gallery-caption">
                            <h5>Distribusi Makanan</h5>
                            <p>Penyaluran donasi makanan ke panti asuhan</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('assets/images/gallery2.jpg') }}" alt="Gallery Item">
                    <div class="gallery-overlay">
                        <div class="gallery-caption">
                            <h5>Edukasi Masyarakat</h5>
                            <p>Workshop mengenai pengurangan sampah makanan</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                    <img src="{{ asset('assets/images/gallery3.jpg') }}" alt="Gallery Item">
                    <div class="gallery-overlay">
                        <div class="gallery-caption">
                            <h5>Pengumpulan Donasi</h5>
                            <p>Mitra kami menyiapkan makanan untuk donasi</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('assets/images/gallery4.jpg') }}" alt="Gallery Item">
                    <div class="gallery-overlay">
                        <div class="gallery-caption">
                            <h5>Kolaborasi Komunitas</h5>
                            <p>Kerjasama dengan komunitas lokal</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="500">
                <a href="#" class="btn btn-outline-primary">Lihat Lebih Banyak Foto</a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5 bg-white" id="guide">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Bagaimana Cara Kerjanya</h2>
                <p class="section-subtitle">Ikuti langkah-langkah sederhana ini untuk mulai berkontribusi</p>
            </div>
            <div class="timeline">
                <div class="timeline-item" data-aos="fade-right" data-aos-delay="100">
                    <div class="timeline-content">
                        <span class="timeline-date">Langkah 1</span>
                        <h3 class="timeline-title">Daftar Akun</h3>
                        <p>Buat akun sebagai donatur atau penerima makanan dalam beberapa langkah mudah.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-left" data-aos-delay="200">
                    <div class="timeline-content">
                        <span class="timeline-date">Langkah 2</span>
                        <h3 class="timeline-title">Tambahkan Donasi atau Permintaan</h3>
                        <p>Daftarkan makanan yang tersedia untuk didonasikan atau ajukan permintaan makanan.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-right" data-aos-delay="300">
                    <div class="timeline-content">
                        <span class="timeline-date">Langkah 3</span>
                        <h3 class="timeline-title">Terhubung dan Berkoordinasi</h3>
                        <p>Donatur dan penerima terhubung untuk mengatur pengambilan atau pengiriman makanan.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-left" data-aos-delay="400">
                    <div class="timeline-content">
                        <span class="timeline-date">Langkah 4</span>
                        <h3 class="timeline-title">Selesaikan Transaksi</h3>
                        <p>Konfirmasikan penyelesaian transaksi dan bagikan dampak positif Anda.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="500">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Gabung Sekarang</a>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-5 bg-gradient-primary" id="faq" style="background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <h2 class="section-title" style="font-weight:700; color:#2c6b2f;">Pertanyaan Umum</h2>
                <p class="section-subtitle" style="color:#4caf50;">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="faq-modern-list">
                        <div class="faq-modern-item" data-aos="fade-up" data-aos-delay="100">
                            <button class="faq-modern-question" onclick="toggleFaq(this)">
                                <span>Apa itu NoFoodWaste?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-modern-answer">
                                NoFoodWaste adalah platform yang menghubungkan donatur makanan (seperti restoran, toko roti, supermarket) dengan penerima yang membutuhkan. Tujuan kami adalah mengurangi pemborosan makanan dan membantu memerangi kelaparan di masyarakat.
                            </div>
                        </div>
                        <div class="faq-modern-item" data-aos="fade-up" data-aos-delay="150">
                            <button class="faq-modern-question" onclick="toggleFaq(this)">
                                <span>Siapa yang bisa menjadi donatur?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-modern-answer">
                                Siapa saja bisa menjadi donatur! Restoran, hotel, supermarket, toko roti, katering, bahkan individu yang memiliki kelebihan makanan berkualitas baik yang akan terbuang dapat mendonasikannya melalui platform kami.
                            </div>
                        </div>
                        <div class="faq-modern-item" data-aos="fade-up" data-aos-delay="200">
                            <button class="faq-modern-question" onclick="toggleFaq(this)">
                                <span>Bagaimana menjamin keamanan makanan?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-modern-answer">
                                Kami memiliki pedoman ketat mengenai jenis makanan yang bisa didonasikan. Makanan harus masih dalam kondisi baik, belum kedaluwarsa, dan disimpan dengan benar. Donatur juga diminta untuk memberikan informasi lengkap tentang makanan, termasuk tanggal kedaluwarsa.
                            </div>
                        </div>
                        <div class="faq-modern-item" data-aos="fade-up" data-aos-delay="250">
                            <button class="faq-modern-question" onclick="toggleFaq(this)">
                                <span>Siapa yang bisa menerima donasi?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-modern-answer">
                                Panti asuhan, panti jompo, soup kitchen, organisasi amal, dan lembaga sosial lainnya bisa mendaftar sebagai penerima donasi. Dalam beberapa kasus, individu yang membutuhkan juga bisa mendaftar dengan verifikasi tertentu.
                            </div>
                        </div>
                        <div class="faq-modern-item" data-aos="fade-up" data-aos-delay="300">
                            <button class="faq-modern-question" onclick="toggleFaq(this)">
                                <span>Apakah ada biaya untuk menggunakan platform ini?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-modern-answer">
                                NoFoodWaste adalah platform nirlaba, dan penggunaan dasar platform ini gratis baik untuk donatur maupun penerima. Kami mungkin membebankan biaya minimal untuk layanan tambahan seperti pengiriman atau fitur premium lainnya.
                            </div>
                        </div>
                        <div class="faq-modern-item" data-aos="fade-up" data-aos-delay="350">
                            <button class="faq-modern-question" onclick="toggleFaq(this)">
                                <span>Bagaimana dengan pengiriman makanan?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-modern-answer">
                                Pengiriman bisa diatur antara donatur dan penerima. Penerima bisa mengambil langsung dari lokasi donatur, atau donatur bisa mengirimkan sendiri. Untuk beberapa area, kami juga bekerja sama dengan mitra logistik yang bisa membantu pengiriman dengan biaya tambahan.
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
                        <a href="#" class="btn btn-accent btn-lg px-4">Lihat Semua FAQ</a>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .faq-modern-list {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 4px 32px rgba(44,107,47,0.08);
                padding: 2rem 2.5rem;
            }
            .faq-modern-item + .faq-modern-item {
                border-top: 1px solid #e0e0e0;
            }
            .faq-modern-question {
                width: 100%;
                background: none;
                border: none;
                outline: none;
                font-size: 1.15rem;
                font-weight: 600;
                color: #2c6b2f;
                padding: 1.25rem 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                transition: color 0.2s;
            }
            .faq-modern-question:hover {
                color: #388e3c;
            }
            .faq-modern-answer {
                display: none;
                color: #444;
                font-size: 1rem;
                padding-bottom: 1.25rem;
                padding-right: 2rem;
                padding-left: 0.5rem;
                line-height: 1.7;
                background: none;
            }
            .faq-modern-item.faq-active .faq-modern-answer {
                display: block;
                animation: fadeInFaq 0.4s;
            }
            .faq-modern-item.faq-active .faq-modern-question i {
                transform: rotate(180deg);
            }
            .faq-modern-question i {
                transition: transform 0.3s;
            }
            @keyframes fadeInFaq {
                from { opacity: 0; transform: translateY(-10px);}
                to { opacity: 1; transform: translateY(0);}
            }
            @media (max-width: 768px) {
                .faq-modern-list {
                    padding: 1rem 0.5rem;
                }
            }
        </style>
        <script>
            // Overwrite toggleFaq for modern FAQ
            function toggleFaq(element) {
                const parent = element.closest('.faq-modern-item');
                parent.classList.toggle('faq-active');
                // Close others
                document.querySelectorAll('.faq-modern-item').forEach(faq => {
                    if (faq !== parent) faq.classList.remove('faq-active');
                });
            }
        </script>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-container">
                <div class="footer-logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="NoFoodWaste Logo">
                    <div class="footer-logo-text">NO FOOD WASTE</div>
                </div>
                
                <div class="footer-section">
                    <h4>Tentang Kami</h4>
                    <ul class="footer-links">
                        <li class="footer-link"><a href="#">Visi & Misi</a></li>
                        <li class="footer-link"><a href="#">Tim Kami</a></li>
                        <li class="footer-link"><a href="#">Mitra</a></li>
                        <li class="footer-link"><a href="#">Blog</a></li>
                        <li class="footer-link"><a href="#">Karir</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul class="footer-links">
                        <li class="footer-link"><a href="#">Donasi Makanan</a></li>
                        <li class="footer-link"><a href="#">Permintaan Makanan</a></li>
                        <li class="footer-link"><a href="#">Statistik</a></li>
                        <li class="footer-link"><a href="#">Program Edukasi</a></li>
                        <li class="footer-link"><a href="#">Korporasi</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <div class="footer-contact">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. Pemborosan No. 0, Jakarta Selatan</span>
                    </div>
                    <div class="footer-contact">
                        <i class="fas fa-envelope"></i>
                        <span>info@nofoodwaste.id</span>
                    </div>
                    <div class="footer-contact">
                        <i class="fas fa-phone"></i>
                        <span>+62 812 3456 7890</span>
                    </div>
                    <div class="footer-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Newsletter</h4>
                    <p>Dapatkan berita dan update terbaru</p>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Anda">
                    </div>
                    <button class="btn btn-accent btn-sm mt-2">Langganan</button>
                    
                    
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} NoFoodWaste. Hak Cipta Dilindungi. <a href="#">Kebijakan Privasi</a> | <a href="#">Syarat dan Ketentuan</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating CTA Button -->
    <a href="{{ route('register') }}" class="btn btn-accent btn-lg floating-cta">
        <i class="fas fa-plus mr-2"></i> Donasi Sekarang
    </a>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init();
            
            // Navbar toggle
            const navbarToggle = document.getElementById('navbarToggle');
            const navbarMenu = document.getElementById('navbarMenu');
            
            if (navbarToggle && navbarMenu) {
                navbarToggle.addEventListener('click', function() {
                    navbarMenu.classList.toggle('show');
                });
            }
            
            // Counter animation
            const counters = document.querySelectorAll('.counter-animation');
            
            // Start counting when elements are in view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.getAttribute('data-count'));
                        let count = 0;
                        const speed = Math.floor(2000 / target); // Adjust for reasonable speed
                        
                        const updateCount = () => {
                            if (count < target) {
                                count += Math.ceil(target / 100);
                                if (count > target) count = target;
                                counter.innerText = count.toLocaleString();
                                setTimeout(updateCount, speed);
                            }
                        };
                        
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            counters.forEach(counter => {
                observer.observe(counter);
            });
        });
        
        // FAQ Toggle
        function toggleFaq(element) {
            const parent = element.parentElement;
            parent.classList.toggle('faq-active');
            
            // Close other FAQs
            const allFaqs = document.querySelectorAll('.faq-item');
            allFaqs.forEach(faq => {
                if (faq !== parent && faq.classList.contains('faq-active')) {
                    faq.classList.remove('faq-active');
                }
            });
        }
    </script>
</body>
</html>
