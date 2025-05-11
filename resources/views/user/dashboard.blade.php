@extends('layouts.user')

@section('title', 'User Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Available Donations</h5>
                                    <h2 id="availableDonations">Loading...</h2>
                                    <a href="{{ route('user.donations') }}" class="btn btn-light mt-3">
                                        View All Donations
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Nearby NGOs</h5>
                                    <h2 id="nearbyNGOs">Loading...</h2>
                                    <a href="{{ route('user.nearby-ngos') }}" class="btn btn-light mt-3">
                                        View Nearby NGOs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Donations</h5>
                                    <a href="{{ route('user.donations') }}" class="btn btn-primary btn-sm">
                                        View All
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="recentDonations">
                                        <div class="col-12 text-center">
                                            <p>Loading...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Success Stories</h5>
                                </div>
                                <div class="card-body">
                                    <div id="successStories">
                                        <p class="text-center">Loading...</p>
                                    </div>
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
        document.getElementById('availableDonations').textContent = '25';
        document.getElementById('nearbyNGOs').textContent = '8';
        
        const recentDonations = `
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Fresh Bread</h5>
                        <p class="card-text">Donated by: Bakery Shop</p>
                        <p class="card-text"><small class="text-muted">Expires: Tomorrow</small></p>
                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pasta and Sauce</h5>
                        <p class="card-text">Donated by: Italian Restaurant</p>
                        <p class="card-text"><small class="text-muted">Expires: Today</small></p>
                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Fruit Platter</h5>
                        <p class="card-text">Donated by: Healthy Eats</p>
                        <p class="card-text"><small class="text-muted">Expires: Today</small></p>
                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('recentDonations').innerHTML = recentDonations;
        
        const successStories = `
            <div class="mb-3">
                <h6>Food Rescue at Local School</h6>
                <p class="small">Harmony NGO distributed 50 meals to students in need last week.</p>
            </div>
            <div class="mb-3">
                <h6>Community Pantry Success</h6>
                <p class="small">Hope Center NGO set up a community pantry serving over 100 families.</p>
            </div>
            <div class="mb-3">
                <h6>Restaurant Reduces Waste</h6>
                <p class="small">Local restaurant reduced food waste by 40% through our platform.</p>
            </div>
        `;
        document.getElementById('successStories').innerHTML = successStories;
    }, 1000);
</script>
@endsection
