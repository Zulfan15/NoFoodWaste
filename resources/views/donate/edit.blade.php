@extends('layouts.admin.master')

@section('title', 'Edit Donasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Donasi</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('donations.update', $donation->donation_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="food_name" class="form-label">Nama Makanan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('food_name') is-invalid @enderror" id="food_name" name="food_name" value="{{ old('food_name', $donation->food_name) }}" required>
                                @error('food_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $donation->quantity) }}" min="1" required>
                                @error('quantity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label">Tanggal Kedaluwarsa <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', \Carbon\Carbon::parse($donation->expiration_date)->format('Y-m-d')) }}" required>
                                @error('expiry_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pickup_location" class="form-label">Lokasi Pengambilan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('pickup_location') is-invalid @enderror" id="pickup_location" name="pickup_location" rows="3" required>{{ old('pickup_location', $donation->pickup_location) }}</textarea>
                                @error('pickup_location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('donations.show', $donation->donation_id) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
