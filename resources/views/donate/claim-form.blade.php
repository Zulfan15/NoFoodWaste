@extends('layouts.admin.master')

@section('title', 'Klaim Donasi - No Food Waste')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/nofoodwaste.css') }}">
<style>
    .donation-details {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--spacing-xl);
        overflow: hidden;
    }
    
    .donation-header {
        padding: var(--spacing-lg) var(--spacing-xl);
        border-bottom: 1px solid var(--neutral-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .donation-title {
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--neutral-800);
        margin: 0;
    }
    
    .donation-status {
        font-size: var(--font-size-sm);
        font-weight: 500;
        padding: 0.3rem 1rem;
        border-radius: var(--radius-full);
        color: white;
    }
    
    .donation-status.available {
        background: var(--success);
    }
    
    .donation-body {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: var(--spacing-lg);
    }
    
    .donation-image {
        padding: var(--spacing-lg);
    }
    
    .donation-image img {
        width: 100%;
        border-radius: var(--radius-md);
        height: 200px;
        object-fit: cover;
    }
    
    .donation-info {
        padding: var(--spacing-lg) var(--spacing-lg) var(--spacing-lg) 0;
    }
    
    .donation-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
    }
    
    .meta-label {
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
        margin-bottom: var(--spacing-xs);
    }
    
    .meta-value {
        font-size: var(--font-size-base);
        font-weight: 500;
        color: var(--neutral-800);
    }
    
    .donor-info {
        display: flex;
        align-items: center;
        padding: var(--spacing-md);
        background: var(--neutral-100);
        border-radius: var(--radius-md);
        margin-bottom: var(--spacing-lg);
    }
    
    .donor-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        margin-right: var(--spacing-md);
    }
    
    .donor-details {
        flex: 1;
    }
    
    .donor-name {
        font-weight: 600;
        color: var(--neutral-800);
        margin-bottom: var(--spacing-xs);
    }
    
    .donor-meta {
        font-size: var(--font-size-sm);
        color: var(--neutral-600);
    }
    
    .claim-form {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: var(--spacing-xl);
    }
    
    .form-title {
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--neutral-800);
        margin-bottom: var(--spacing-lg);
    }
    
    .form-group {
        margin-bottom: var(--spacing-lg);
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: var(--spacing-xs);
        display: block;
    }
    
    .form-footer {
        display: flex;
        justify-content: space-between;
        margin-top: var(--spacing-xl);
    }
    
    @media (max-width: 768px) {
        .donation-body {
            grid-template-columns: 1fr;
        }
        
        .donation-image {
            padding: var(--spacing-lg) var(--spacing-lg) 0 var(--spacing-lg);
        }
        
        .donation-info {
            padding: 0 var(--spacing-lg) var(--spacing-lg) var(--spacing-lg);
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
                    <h3>Klaim Donasi</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('find-donations') }}">Cari Donasi</a></li>
                        <li class="breadcrumb-item active">Klaim Donasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <!-- Donation Details -->
            <div class="donation-details">
                <div class="donation-header">
                    <h4 class="donation-title">{{ $donation->food_name }}</h4>
                    <div class="donation-status available">Tersedia</div>
                </div>
                <div class="donation-body">
                    <div class="donation-image">
                        @if($donation->image)
                            <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->food_name }}">
                        @else
                            <img src="{{ asset('assets/images/food-placeholder.jpg') }}" alt="{{ $donation->food_name }}">
                        @endif
                    </div>
                    <div class="donation-info">
                        <div class="donation-meta">
                            <div class="meta-item">
                                <span class="meta-label">Jumlah</span>
                                <span class="meta-value">{{ $donation->quantity }} {{ $donation->unit ?? 'Porsi' }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Kategori</span>
                                <span class="meta-value">{{ $donation->category ?? 'Umum' }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Lokasi Pengambilan</span>
                                <span class="meta-value">{{ $donation->pickup_location }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Kedaluwarsa</span>
                                <span class="meta-value">{{ \Carbon\Carbon::parse($donation->expiration_date)->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                        
                        <div class="donor-info">
                            <img src="{{ asset($donation->donor->profile_image ?? 'assets/images/user-placeholder.jpg') }}" alt="{{ $donation->donor->name }}" class="donor-avatar">
                            <div class="donor-details">
                                <h5 class="donor-name">{{ $donation->donor->name }}</h5>
                                <div class="donor-meta">
                                    <span>Donatur</span>
                                </div>
                            </div>
                        </div>
                        
                        <p>{{ $donation->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Claim Form -->
            <div class="claim-form">
                <h4 class="form-title">Form Klaim Donasi</h4>
                
                <form action="{{ route('donations.claim', $donation->donation_id) }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Tambahkan catatan untuk donatur, misalnya waktu pengambilan yang diinginkan"></textarea>
                        <small class="form-text text-muted">Catatan ini akan dikirim kepada donatur.</small>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="termsCheck" required>
                            <label class="custom-control-label" for="termsCheck">
                                Saya menyatakan bahwa makanan ini akan saya gunakan dengan baik dan tidak akan dijual kembali.
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-footer">
                        <a href="{{ route('find-donations') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Klaim Donasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
