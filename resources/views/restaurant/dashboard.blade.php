@extends('layouts.restaurant')

@section('title', 'Restaurant Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Restaurant Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Donations</h5>
                                    <h2 id="totalDonations">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Claimed Donations</h5>
                                    <h2 id="claimedDonations">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Pending Donations</h5>
                                    <h2 id="pendingDonations">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Expired Donations</h5>
                                    <h2 id="expiredDonations">Loading...</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Donations</h5>
                                    <a href="{{ route('restaurant.donations.create') }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-plus-circle"></i> Add Donation
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentDonations">
                                            <tr>
                                                <td colspan="5" class="text-center">Loading...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simulasi data - dalam implementasi nyata, ini akan diambil dari API
    setTimeout(function() {
        document.getElementById('totalDonations').textContent = '42';
        document.getElementById('claimedDonations').textContent = '28';
        document.getElementById('pendingDonations').textContent = '10';
        document.getElementById('expiredDonations').textContent = '4';
        
        const recentDonations = `
            <tr>
                <td>Fresh Bread</td>
                <td>20 loaves</td>
                <td>Tomorrow</td>
                <td><span class="badge bg-success">Available</span></td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View</a>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            <tr>
                <td>Pasta and Sauce</td>
                <td>15 servings</td>
                <td>Today</td>
                <td><span class="badge bg-warning">Claimed</span></td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View</a>
                </td>
            </tr>
            <tr>
                <td>Fruit Platter</td>
                <td>8 plates</td>
                <td>Today</td>
                <td><span class="badge bg-success">Available</span></td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View</a>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
        `;
        document.getElementById('recentDonations').innerHTML = recentDonations;
    }, 1000);
</script>
@endsection
