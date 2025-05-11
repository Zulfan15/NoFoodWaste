@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Donation</h1>
        <a href="{{ route('admin.donations.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Donations
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Donation #{{ $donation->donation_id }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.donations.update', $donation->donation_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="food_name">Food Name</label>
                    <input type="text" class="form-control @error('food_name') is-invalid @enderror" id="food_name" name="food_name" value="{{ old('food_name', $donation->food_name) }}" required>
                    @error('food_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $donation->quantity) }}" min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pickup_location">Pickup Location</label>
                    <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" id="pickup_location" name="pickup_location" value="{{ old('pickup_location', $donation->pickup_location) }}" required>
                    @error('pickup_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expiration_date">Expiration Date</label>
                    <input type="datetime-local" class="form-control @error('expiration_date') is-invalid @enderror" id="expiration_date" name="expiration_date" value="{{ old('expiration_date', $donation->expiration_date->format('Y-m-d\TH:i')) }}" required>
                    @error('expiration_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="available" {{ old('status', $donation->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="claimed" {{ old('status', $donation->status) == 'claimed' ? 'selected' : '' }}>Claimed</option>
                        <option value="expired" {{ old('status', $donation->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Donation</button>
            </form>
        </div>
    </div>
</div>
@endsection
