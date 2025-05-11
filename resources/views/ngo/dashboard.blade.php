@extends('layouts.ngo')

@section('title', 'NGO Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">NGO Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Claims</h5>
                                    <h2 id="totalClaims">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Completed Claims</h5>
                                    <h2 id="completedClaims">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Available Donations</h5>
                                    <h2 id="availableDonations">Loading...</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Claims</h5>
                                    <a href="{{ route('ngo.claim-history') }}" class="btn btn-info btn-sm">
                                        View All
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Donation</th>
                                                <th>Restaurant</th>
                                                <th>Date Claimed</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentClaims">
                                            <tr>
                                                <td colspan="4" class="text-center">Loading...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Available Donations</h5>
                                    <a href="{{ route('ngo.available-donations') }}" class="btn btn-success btn-sm">
                                        View All
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Donation</th>
                                                <th>Restaurant</th>
                                                <th>Expiry Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="availableDonationsList">
                                            <tr>
                                                <td colspan="4" class="text-center">Loading...</td>
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
        document.getElementById('totalClaims').textContent = '36';
        document.getElementById('completedClaims').textContent = '31';
        document.getElementById('availableDonations').textContent = '15';
        
        const recentClaims = `
            <tr>
                <td>Fresh Bread</td>
                <td>Bakery Shop</td>
                <td>Today</td>
                <td><span class="badge bg-warning">Pending</span></td>
            </tr>
            <tr>
                <td>Pasta and Sauce</td>
                <td>Italian Restaurant</td>
                <td>Yesterday</td>
                <td><span class="badge bg-success">Completed</span></td>
            </tr>
            <tr>
                <td>Soups</td>
                <td>Food Corner</td>
                <td>2 days ago</td>
                <td><span class="badge bg-success">Completed</span></td>
            </tr>
        `;
        document.getElementById('recentClaims').innerHTML = recentClaims;
        
        const availableDonationsList = `
            <tr>
                <td>Rice and Curry</td>
                <td>Indian Delight</td>
                <td>Tomorrow</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View</a>
                    <a href="#" class="btn btn-sm btn-success">Claim</a>
                </td>
            </tr>
            <tr>
                <td>Sandwich Platter</td>
                <td>Café Express</td>
                <td>Today</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View</a>
                    <a href="#" class="btn btn-sm btn-success">Claim</a>
                </td>
            </tr>
            <tr>
                <td>Vegetable Mix</td>
                <td>Green Foods</td>
                <td>Tomorrow</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">View</a>
                    <a href="#" class="btn btn-sm btn-success">Claim</a>
                </td>
            </tr>
        `;
        document.getElementById('availableDonationsList').innerHTML = availableDonationsList;
    }, 1000);
</script>
@endsection
