@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Users</h5>
                                    <h2 id="totalUsers">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Restaurants</h5>
                                    <h2 id="totalRestaurants">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total NGOs</h5>
                                    <h2 id="totalNGOs">Loading...</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Donations</h5>
                                    <h2 id="totalDonations">Loading...</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Recent Users</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentUsers">
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
                                <div class="card-header">
                                    <h5 class="card-title">Recent Donations</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Restaurant</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentDonations">
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
        document.getElementById('totalUsers').textContent = '1,254';
        document.getElementById('totalRestaurants').textContent = '328';
        document.getElementById('totalNGOs').textContent = '156';
        document.getElementById('totalDonations').textContent = '3,752';
        
        const recentUsers = `
            <tr>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>User</td>
                <td>2 hours ago</td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>Restaurant</td>
                <td>3 hours ago</td>
            </tr>
            <tr>
                <td>Robert Johnson</td>
                <td>robert@example.com</td>
                <td>NGO</td>
                <td>5 hours ago</td>
            </tr>
        `;
        document.getElementById('recentUsers').innerHTML = recentUsers;
        
        const recentDonations = `
            <tr>
                <td>Fresh Bread</td>
                <td>Bakery Shop</td>
                <td>Available</td>
                <td>1 hour ago</td>
            </tr>
            <tr>
                <td>Pasta and Sauce</td>
                <td>Italian Restaurant</td>
                <td>Claimed</td>
                <td>3 hours ago</td>
            </tr>
            <tr>
                <td>Fruit Platter</td>
                <td>Healthy Eats</td>
                <td>Available</td>
                <td>4 hours ago</td>
            </tr>
        `;
        document.getElementById('recentDonations').innerHTML = recentDonations;
    }, 1000);
</script>
@endsection
