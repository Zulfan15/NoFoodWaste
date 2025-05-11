@extends('layouts.admin')

@section('title', 'Restaurant Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Restaurant Details</h2>
                <div>
                    <a href="{{ route('admin.restaurants.edit', $restaurant->user_id) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil"></i> Edit Restaurant
                    </a>
                    <a href="{{ route('admin.restaurants.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Restaurants
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Restaurant Information</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID</th>
                            <td>{{ $restaurant->user_id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $restaurant->username }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $restaurant->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>{{ $restaurant->phone_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $restaurant->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $restaurant->created_at ? $restaurant->created_at->format('F d, Y H:i:s') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $restaurant->updated_at ? $restaurant->updated_at->format('F d, Y H:i:s') : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Restaurant Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-primary mb-2">
                                    <i class="bi bi-box-arrow-up-right"></i> View Donations
                                </a>
                                <form action="{{ route('admin.restaurants.destroy', $restaurant->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this restaurant? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Delete Restaurant
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
