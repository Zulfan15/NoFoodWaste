@extends('layouts.admin')

@section('title', 'Admin Statistics')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>System Statistics</h2>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Donations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDonations }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Claimed Donations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $claimedDonations }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Success Rate</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalDonations > 0 ? round(($claimedDonations / $totalDonations) * 100) : 0 }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-graph-up fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <!-- Monthly Donations Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Donations ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlyDonationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donation Status Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Donation Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="donationStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-success"></i> Available
                        </span>
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-info"></i> Claimed
                        </span>
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-danger"></i> Expired
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User and Activity Statistics -->
    <div class="row">
        <!-- User Role Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Distribution by Role</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-danger"></i> Admin
                        </span>
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-primary"></i> Restaurant
                        </span>
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-success"></i> NGO
                        </span>
                        <span class="mr-2">
                            <i class="bi bi-circle-fill text-secondary"></i> User
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Donors -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Donors</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Restaurant</th>
                                    <th>Email</th>
                                    <th>Total Donations</th>
                                    <th>Claimed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topDonors as $index => $donor)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $donor->username }}</td>
                                    <td>{{ $donor->email }}</td>
                                    <td>{{ $donor->donations_count }}</td>
                                    <td>{{ $donor->claimed_donations_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Donations</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Food Name</th>
                                    <th>Donated By</th>
                                    <th>Quantity</th>
                                    <th>Expiration Date</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentDonations as $donation)
                                <tr>
                                    <td>{{ $donation->donation_id }}</td>
                                    <td>{{ $donation->food_name }}</td>
                                    <td>{{ $donation->donor->username ?? 'Unknown' }}</td>
                                    <td>{{ $donation->quantity }}</td>
                                    <td>{{ $donation->expiration_date->format('M d, Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $donation->status == 'available' ? 'success' : ($donation->status == 'claimed' ? 'info' : 'danger') }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $donation->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No recent donations</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Donations Chart
        const monthlyData = @json($monthlyDonations ?? []);
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        
        const dataByMonth = Array(12).fill(0);
        const claimedByMonth = Array(12).fill(0);
        
        if (monthlyData && monthlyData.length) {
            monthlyData.forEach(item => {
                if (item.month && item.count) {
                    dataByMonth[parseInt(item.month) - 1] = parseInt(item.count);
                }
                if (item.month && item.claimed_count) {
                    claimedByMonth[parseInt(item.month) - 1] = parseInt(item.claimed_count);
                }
            });
        }
        
        if (document.getElementById('monthlyDonationsChart')) {
            new Chart(document.getElementById('monthlyDonationsChart'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Total Donations',
                            data: dataByMonth,
                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                            borderColor: 'rgba(78, 115, 223, 1)',
                            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Claimed Donations',
                            data: claimedByMonth,
                            backgroundColor: 'rgba(28, 200, 138, 0.05)',
                            borderColor: 'rgba(28, 200, 138, 1)',
                            pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
        
        // Donation Status Chart
        if (document.getElementById('donationStatusChart')) {
            new Chart(document.getElementById('donationStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Claimed', 'Expired'],
                    datasets: [{
                        data: [
                            {{ $availableDonations ?? 0 }}, 
                            {{ $claimedDonations ?? 0 }}, 
                            {{ $expiredDonations ?? 0 }}
                        ],
                        backgroundColor: ['#1cc88a', '#36b9cc', '#e74a3b'],
                        hoverBackgroundColor: ['#169c70', '#2c9faf', '#c93a2e'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
        
        // User Role Chart
        if (document.getElementById('userRoleChart')) {
            new Chart(document.getElementById('userRoleChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Admin', 'Restaurant', 'NGO', 'User'],
                    datasets: [{
                        data: [
                            {{ $adminCount ?? 0 }}, 
                            {{ $restaurantCount ?? 0 }}, 
                            {{ $ngoCount ?? 0 }}, 
                            {{ $userCount ?? 0 }}
                        ],
                        backgroundColor: ['#e74a3b', '#4e73df', '#1cc88a', '#858796'],
                        hoverBackgroundColor: ['#c93a2e', '#3a58b6', '#169c70', '#6e707e'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
