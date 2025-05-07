@extends('layouts.admin.master')

@section('title', 'Donasi Makanan - No Food Waste')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg) var(--spacing-xl);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--spacing-xl);
        color: white;
    }
    
    .page-header h3 {
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
    
    .donation-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: var(--spacing-xl);
        margin-bottom: var(--spacing-2xl);
    }
    
    .donation-form-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }
    
    .donation-form-header {
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--neutral-200);
    }
    
    .donation-form-title {
        font-size: var(--font-size-xl);
        font-weight: 600;
        color: var(--neutral-800);
        margin: 0;
    }
    
    .donation-form-subtitle {
        font-size: var(--font-size-base);
        color: var(--neutral-600);
        margin-top: var(--spacing-xs);
    }
    
    .donation-form-body {
        padding: var(--spacing-xl);
    }
    
    .form-group {
        margin-bottom: var(--spacing-lg);
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: var(--spacing-xs);
        color: var(--neutral-800);
    }
    
    .form-hint {
        display: block;
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
        margin-top: var(--spacing-xs);
    }
    
    .donation-sidebar {
        position: sticky;
        top: 20px;
    }
    
    .donation-info-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--spacing-lg);
    }
    
    .donation-info-header {
        background: linear-gradient(to right, var(--accent-light), var(--accent));
        color: white;
        padding: var(--spacing-md) var(--spacing-lg);
        border-top-left-radius: var(--radius-lg);
        border-top-right-radius: var(--radius-lg);
    }
    
    .donation-info-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin: 0;
    }
    
    .donation-info-body {
        padding: var(--spacing-lg);
    }
    
    .donation-tip {
        display: flex;
        align-items: flex-start;
        margin-bottom: var(--spacing-md);
    }
    
    .donation-tip:last-child {
        margin-bottom: 0;
    }
    
    .donation-tip-icon {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-full);
        background: var(--accent-light);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: var(--spacing-md);
        flex-shrink: 0;
    }
    
    .donation-tip-content h5 {
        font-size: var(--font-size-base);
        font-weight: 600;
        margin: 0 0 var(--spacing-xs);
        color: var(--neutral-800);
    }
    
    .donation-tip-content p {
        font-size: var(--font-size-sm);
        color: var(--neutral-700);
        margin: 0;
    }
    
    .donation-preview-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }
    
    .donation-preview-header {
        background: linear-gradient(to right, var(--primary-light), var(--primary));
        color: white;
        padding: var(--spacing-md) var(--spacing-lg);
    }
    
    .donation-preview-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin: 0;
    }
    
    .donation-preview-body {
        padding: var(--spacing-lg);
    }
    
    .donation-preview-image {
        width: 100%;
        height: 180px;
        border-radius: var(--radius-md);
        background-color: var(--neutral-200);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: var(--spacing-md);
        overflow: hidden;
        position: relative;
    }
    
    .donation-preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .donation-preview-placeholder {
        color: var(--neutral-600);
        text-align: center;
    }
    
    .donation-preview-placeholder i {
        font-size: 2.5rem;
        margin-bottom: var(--spacing-sm);
        opacity: 0.6;
    }
    
    .donation-preview-info {
        margin-bottom: var(--spacing-md);
    }
    
    .donation-preview-name {
        font-size: var(--font-size-lg);
        font-weight: 600;
        color: var(--neutral-800);
        margin: 0 0 var(--spacing-xs);
    }
    
    .donation-preview-details {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .donation-preview-detail {
        display: flex;
        margin-bottom: var(--spacing-xs);
        color: var(--neutral-700);
        font-size: var(--font-size-sm);
    }
    
    .donation-preview-detail i {
        width: 20px;
        margin-right: var(--spacing-sm);
        color: var(--primary);
    }
    
    .donation-preview-description {
        font-size: var(--font-size-sm);
        color: var(--neutral-700);
        background: var(--neutral-100);
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        max-height: 100px;
        overflow-y: auto;
    }
    
    .image-upload-container {
        position: relative;
        border: 2px dashed var(--neutral-400);
        border-radius: var(--radius-md);
        padding: var(--spacing-lg);
        text-align: center;
        transition: var(--transition-normal);
        cursor: pointer;
        overflow: hidden;
    }
    
    .image-upload-container:hover {
        border-color: var(--primary);
        background-color: var(--neutral-100);
    }
    
    .image-upload-icon {
        font-size: 2.5rem;
        color: var(--neutral-500);
        margin-bottom: var(--spacing-sm);
    }
    
    .image-upload-text {
        color: var(--neutral-700);
    }
    
    .image-upload-help {
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
        margin-top: var(--spacing-xs);
    }
    
    #imagePreview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    
    .image-preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition-normal);
    }
    
    .image-upload-container:hover .image-preview-overlay {
        opacity: 1;
    }
    
    .image-preview-actions {
        display: flex;
        gap: var(--spacing-sm);
    }
    
    .image-preview-action {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-full);
        background: white;
        color: var(--neutral-800);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition-fast);
    }
    
    .image-preview-action:hover {
        background: var(--primary);
        color: white;
    }
    
    #foodImageInput {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .form-submit {
        padding: var(--spacing-lg);
        background: var(--neutral-100);
        border-top: 1px solid var(--neutral-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .donation-steps {
        display: flex;
        margin-bottom: var(--spacing-xl);
    }
    
    .donation-step {
        flex: 1;
        text-align: center;
        position: relative;
    }
    
    .donation-step:not(:last-child):after {
        content: '';
        position: absolute;
        top: 20px;
        right: 0;
        width: calc(100% - 40px);
        height: 2px;
        background: var(--neutral-300);
        z-index: 1;
    }
    
    .donation-step.active:not(:last-child):after {
        background: var(--primary);
    }
    
    .donation-step-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-full);
        background: var(--neutral-300);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--spacing-sm);
        position: relative;
        z-index: 2;
    }
    
    .donation-step.active .donation-step-icon {
        background: var(--primary);
    }
    
    .donation-step.completed .donation-step-icon {
        background: var(--success);
    }
    
    .donation-step-label {
        font-size: var(--font-size-sm);
        font-weight: 500;
        color: var(--neutral-600);
    }
    
    .donation-step.active .donation-step-label {
        color: var(--primary);
        font-weight: 600;
    }
    
    .donation-step.completed .donation-step-label {
        color: var(--success);
    }
    
    .select2-container--default .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        border: 1px solid var(--neutral-400);
        border-radius: var(--radius-md);
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        color: var(--neutral-800);
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(1.5em + 0.75rem + 2px);
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary);
    }
    
    .location-map {
        height: 300px;
        border-radius: var(--radius-md);
        margin-top: var(--spacing-sm);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .donation-container {
            grid-template-columns: 1fr;
        }
        
        .donation-sidebar {
            position: static;
        }
    }
    
    @media (max-width: 576px) {
        .donation-steps {
            flex-direction: column;
            gap: var(--spacing-md);
        }
        
        .donation-step:not(:last-child):after {
            display: none;
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
                    <h3>Donasi Makanan</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Donasi Makanan</li>
                    </ol>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('donation-history') }}" class="btn btn-light">
                        <i class="fas fa-history me-2"></i>Riwayat Donasi Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Donation Steps -->
    <div class="donation-steps">
        <div class="donation-step active">
            <div class="donation-step-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="donation-step-label">Isi Detail Donasi</div>
        </div>
        <div class="donation-step">
            <div class="donation-step-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="donation-step-label">Konfirmasi</div>
        </div>
        <div class="donation-step">
            <div class="donation-step-icon">
                <i class="fas fa-heart"></i>
            </div>
            <div class="donation-step-label">Donasi Berhasil</div>
        </div>
    </div>
    
    <div class="donation-container">
        <!-- Donation Form -->
        <div class="donation-form-card">
            <div class="donation-form-header">
                <h4 class="donation-form-title">Formulir Donasi Makanan</h4>
                <p class="donation-form-subtitle">Silakan isi detail makanan yang ingin Anda donasikan</p>
            </div>
            
            <div class="donation-form-body">
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form id="donationForm" action="{{ route('donate.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="foodName" class="form-label">Nama Makanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('foodName') is-invalid @enderror" id="foodName" name="foodName" value="{{ old('foodName') }}" required placeholder="Contoh: Nasi Kotak, Roti, Buah-buahan">
                        <small class="form-hint">Masukkan nama makanan yang spesifik dan deskriptif</small>
                        @error('foodName')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="foodCategory" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control @error('foodCategory') is-invalid @enderror" id="foodCategory" name="foodCategory" required>
                            <option value="">Pilih kategori makanan</option>
                            <option value="Makanan Siap Saji" {{ old('foodCategory') == 'Makanan Siap Saji' ? 'selected' : '' }}>Makanan Siap Saji</option>
                            <option value="Bahan Makanan" {{ old('foodCategory') == 'Bahan Makanan' ? 'selected' : '' }}>Bahan Makanan</option>
                            <option value="Roti & Kue" {{ old('foodCategory') == 'Roti & Kue' ? 'selected' : '' }}>Roti & Kue</option>
                            <option value="Buah & Sayur" {{ old('foodCategory') == 'Buah & Sayur' ? 'selected' : '' }}>Buah & Sayur</option>
                            <option value="Makanan Kaleng" {{ old('foodCategory') == 'Makanan Kaleng' ? 'selected' : '' }}>Makanan Kaleng</option>
                            <option value="Minuman" {{ old('foodCategory') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Lainnya" {{ old('foodCategory') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('foodCategory')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="1" placeholder="Contoh: 10">
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit" class="form-label">Satuan <span class="text-danger">*</span></label>
                                <select class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                    <option value="">Pilih satuan</option>
                                    <option value="Porsi" {{ old('unit') == 'Porsi' ? 'selected' : '' }}>Porsi</option>
                                    <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box</option>
                                    <option value="Lusin" {{ old('unit') == 'Lusin' ? 'selected' : '' }}>Lusin</option>
                                    <option value="Liter" {{ old('unit') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                </select>
                                @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiryDate" class="form-label">Tanggal Kedaluwarsa <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('expiryDate') is-invalid @enderror" id="expiryDate" name="expiryDate" value="{{ old('expiryDate') }}" required placeholder="YYYY-MM-DD">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <small class="form-hint">Pilih tanggal atau waktu kedaluwarsa makanan</small>
                                @error('expiryDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pickupDeadline" class="form-label">Batas Waktu Pengambilan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('pickupDeadline') is-invalid @enderror" id="pickupDeadline" name="pickupDeadline" value="{{ old('pickupDeadline') }}" required placeholder="YYYY-MM-DD HH:MM">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                </div>
                                <small class="form-hint">Sampai kapan donasi ini dapat diambil</small>
                                @error('pickupDeadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi Makanan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required placeholder="Berikan deskripsi detail tentang makanan yang didonasikan">{{ old('description') }}</textarea>
                        <small class="form-hint">Jelaskan detail makanan, kondisi, dan informasi penting lainnya</small>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="storageInstructions" class="form-label">Instruksi Penyimpanan</label>
                        <textarea class="form-control @error('storageInstructions') is-invalid @enderror" id="storageInstructions" name="storageInstructions" rows="2" placeholder="Contoh: Simpan dalam kulkas, Jangan kena panas, dll.">{{ old('storageInstructions') }}</textarea>
                        @error('storageInstructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="foodImage" class="form-label">Foto Makanan <span class="text-danger">*</span></label>
                        <div class="image-upload-container">
                            <div id="uploadPlaceholder">
                                <div class="image-upload-icon">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <div class="image-upload-text">Klik untuk mengunggah foto makanan</div>
                                <div class="image-upload-help">Format: JPG, PNG, atau WEBP (Maks. 5MB)</div>
                            </div>
                            <img id="imagePreview" src="#" alt="Preview">
                            <input type="file" id="foodImageInput" name="foodImage" accept="image/*" required>
                            <div class="image-preview-overlay" style="display: none;">
                                <div class="image-preview-actions">
                                    <div class="image-preview-action" onclick="changeFoodImage()">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="image-preview-action" onclick="removeFoodImage()">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('foodImage')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="pickupAddress" class="form-label">Alamat Pengambilan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pickupAddress') is-invalid @enderror" id="pickupAddress" name="pickupAddress" value="{{ old('pickupAddress') }}" required placeholder="Masukkan alamat lengkap untuk pengambilan">
                        @error('pickupAddress')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="location" class="form-label">Lokasi di Peta</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="searchLocation" placeholder="Cari lokasi...">
                            <button class="btn btn-primary" type="button" id="findLocationBtn">Cari</button>
                        </div>
                        <div id="locationMap" class="location-map"></div>
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="contactPhone" class="form-label">Nomor Telepon Kontak <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+62</span>
                            <input type="text" class="form-control @error('contactPhone') is-invalid @enderror" id="contactPhone" name="contactPhone" value="{{ old('contactPhone') }}" required placeholder="8123456789">
                        </div>
                        <small class="form-hint">Nomor yang dapat dihubungi untuk koordinasi pengambilan</small>
                        @error('contactPhone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-0">
                        <div class="form-check">
                            <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required {{ old('terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="terms">
                                Saya menyatakan bahwa makanan yang didonasikan masih layak konsumsi dan informasi yang diberikan adalah benar
                            </label>
                            @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="form-submit">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" form="donationForm" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Donasi
                </button>
            </div>
        </div>
        
        <!-- Donation Sidebar -->
        <div class="donation-sidebar">
            <!-- Donation Preview -->
            <div class="donation-preview-card">
                <div class="donation-preview-header">
                    <h4 class="donation-preview-title">Pratinjau Donasi</h4>
                </div>
                <div class="donation-preview-body">
                    <div class="donation-preview-image">
                        <div class="donation-preview-placeholder" id="imagePreviewPlaceholder">
                            <i class="fas fa-image"></i>
                            <p>Gambar donasi akan muncul di sini</p>
                        </div>
                        <img id="sidebarImagePreview" src="#" alt="Preview" style="display: none;">
                    </div>
                    
                    <div class="donation-preview-info">
                        <h5 class="donation-preview-name" id="previewName">Nama Makanan</h5>
                        <ul class="donation-preview-details">
                            <li class="donation-preview-detail">
                                <i class="fas fa-th-large"></i>
                                <span id="previewCategory">Kategori Makanan</span>
                            </li>
                            <li class="donation-preview-detail">
                                <i class="fas fa-box"></i>
                                <span id="previewQuantity">0 Porsi</span>
                            </li>
                            <li class="donation-preview-detail">
                                <i class="fas fa-calendar-alt"></i>
                                <span id="previewExpiry">Kedaluwarsa: -</span>
                            </li>
                            <li class="donation-preview-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span id="previewAddress">Alamat pengambilan</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="donation-preview-description" id="previewDescription">
                        Deskripsi makanan akan muncul di sini setelah Anda mengisi formulir.
                    </div>
                </div>
            </div>
            
            <!-- Donation Tips -->
            <div class="donation-info-card">
                <div class="donation-info-header">
                    <h4 class="donation-info-title">Tips Donasi Makanan</h4>
                </div>
                <div class="donation-info-body">
                    <div class="donation-tip">
                        <div class="donation-tip-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="donation-tip-content">
                            <h5>Pastikan Makanan Layak Konsumsi</h5>
                            <p>Donasikan makanan yang masih dalam kondisi baik dan aman untuk dikonsumsi.</p>
                        </div>
                    </div>
                    
                    <div class="donation-tip">
                        <div class="donation-tip-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="donation-tip-content">
                            <h5>Unggah Foto yang Jelas</h5>
                            <p>Foto yang jelas dan menarik akan meningkatkan peluang donasi Anda diambil.</p>
                        </div>
                    </div>
                    
                    <div class="donation-tip">
                        <div class="donation-tip-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="donation-tip-content">
                            <h5>Berikan Informasi Lengkap</h5>
                            <p>Jelaskan detail makanan, termasuk bahan-bahan dan instruksi penyimpanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Donasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Pastikan semua informasi yang Anda berikan sudah benar. Donasi ini akan dipublikasikan dan dapat diambil oleh penerima yang membutuhkan.</p>
                <p class="mb-0">Apakah Anda yakin ingin melanjutkan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Ya, Donasikan Sekarang</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#foodCategory, #unit').select2({
            theme: 'bootstrap4'
        });
        
        // Initialize Flatpickr for date picker
        flatpickr("#expiryDate", {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: "today",
            allowInput: true
        });
        
        // Initialize Flatpickr for datetime picker
        flatpickr("#pickupDeadline", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            time_24hr: true,
            allowInput: true
        });
        
        // Initialize Map
        let map = L.map('locationMap').setView([-6.200000, 106.816666], 13); // Jakarta coordinates
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        let marker;
        
        map.on('click', function(e) {
            setMarkerPosition(e.latlng.lat, e.latlng.lng);
        });
        
        function setMarkerPosition(lat, lng) {
            $('#latitude').val(lat);
            $('#longitude').val(lng);
            
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            
            map.panTo([lat, lng]);
        }
        
        // Find location button
        $('#findLocationBtn').click(function() {
            const location = $('#searchLocation').val();
            if (location) {
                // In a real app, use a geocoding service like Nominatim or Google Maps
                // For this example, we'll just simulate it
                alert('Searching for: ' + location + '\nThis would use a geocoding service in a real implementation.');
            }
        });
        
        // Image Upload Preview
        $('#foodImageInput').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                    $('#sidebarImagePreview').attr('src', e.target.result).show();
                    $('#uploadPlaceholder').hide();
                    $('.image-preview-overlay').show();
                    $('#imagePreviewPlaceholder').hide();
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Real-time Preview Updates
        $('#foodName').on('input', function() {
            $('#previewName').text($(this).val() || 'Nama Makanan');
        });
        
        $('#foodCategory').on('change', function() {
            $('#previewCategory').text($(this).val() || 'Kategori Makanan');
        });
        
        $('#quantity, #unit').on('input change', function() {
            const quantity = $('#quantity').val() || '0';
            const unit = $('#unit').val() || 'Porsi';
            $('#previewQuantity').text(quantity + ' ' + unit);
        });
        
        $('#expiryDate').on('change', function() {
            $('#previewExpiry').text('Kedaluwarsa: ' + ($(this).val() || '-'));
        });
        
        $('#description').on('input', function() {
            $('#previewDescription').text($(this).val() || 'Deskripsi makanan akan muncul di sini setelah Anda mengisi formulir.');
        });
        
        $('#pickupAddress').on('input', function() {
            $('#previewAddress').text($(this).val() || 'Alamat pengambilan');
        });
        
        // Form submission with confirmation
        $('#submitBtn').click(function(e) {
            e.preventDefault();
            
            // Basic form validation
            if ($('#donationForm')[0].checkValidity()) {
                $('#confirmationModal').modal('show');
            } else {
                $('#donationForm')[0].reportValidity();
            }
        });
        
        $('#confirmSubmitBtn').click(function() {
            $('#donationForm').submit();
        });
    });
    
    // Functions for image actions
    function removeFoodImage() {
        $('#foodImageInput').val('');
        $('#imagePreview').hide().attr('src', '#');
        $('#sidebarImagePreview').hide().attr('src', '#');
        $('#uploadPlaceholder').show();
        $('.image-preview-overlay').hide();
        $('#imagePreviewPlaceholder').show();
    }
    
    function changeFoodImage() {
        $('#foodImageInput').click();
    }
</script>
@endpush