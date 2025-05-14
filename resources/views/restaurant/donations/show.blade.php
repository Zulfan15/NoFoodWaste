@extends('layouts.restaurant')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Donation Details</h1>
        <div>
            @if($donation->status == 'available')
            <a href="{{ route('restaurant.donations.edit', $donation->donation_id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <form action="{{ route('restaurant.donations.destroy', $donation->donation_id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donation?')">
                    <i class="fas fa-trash fa-sm text-white-50"></i> Delete
                </button>
            </form>
            @endif
            <a href="{{ route('restaurant.donations.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Donation Information</h6>
                    <span class="badge badge-{{ $donation->status == 'available' ? 'success' : ($donation->status == 'claimed' ? 'info' : 'danger') }}">
                        {{ ucfirst($donation->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Donation ID:</div>
                        <div class="col-md-9">{{ $donation->donation_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Food Name:</div>
                        <div class="col-md-9">{{ $donation->food_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Quantity:</div>
                        <div class="col-md-9">{{ $donation->quantity }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Pickup Location:</div>
                        <div class="col-md-9">{{ $donation->pickup_location }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Expiration Date:</div>
                        <div class="col-md-9">{{ $donation->expiration_date->format('F j, Y, g:i a') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Status:</div>
                        <div class="col-md-9">
                            <span class="badge badge-{{ $donation->status == 'available' ? 'success' : ($donation->status == 'claimed' ? 'info' : 'danger') }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Created At:</div>
                        <div class="col-md-9">{{ $donation->created_at->format('F j, Y, g:i a') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Updated At:</div>
                        <div class="col-md-9">{{ $donation->updated_at->format('F j, Y, g:i a') }}</div>
                    </div>
                    @if($donation->image)
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Image:</div>
                        <div class="col-md-9">
                            <img src="{{ asset('storage/' . $donation->image) }}" alt="Donation Image" class="img-fluid" style="max-height: 300px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($donation->claim)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Claim Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Claim ID:</div>
                        <div class="col-md-8">{{ $donation->claim->claim_id }}</div>
                    </div>                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Claimed By:</div>
                        <div class="col-md-8">{{ $donation->claim->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Claim Time:</div>
                        <div class="col-md-8">{{ $donation->claim->created_at->format('F j, Y, g:i a') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge badge-{{ $donation->claim->status == 'approved' ? 'success' : ($donation->claim->status == 'pending' ? 'warning' : ($donation->claim->status == 'completed' ? 'info' : 'danger')) }}">
                                {{ ucfirst($donation->claim->status) }}
                            </span>
                        </div>                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8">{{ $donation->claim->user->email ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Phone:</div>
                        <div class="col-md-8">{{ $donation->claim->user->phone ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
