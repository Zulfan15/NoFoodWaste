@extends('layouts.admin.master')

@section('title', 'Aktivitas Saya')

@section('content')
@if(Auth::check())
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ringkasan Aktivitas</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Donasi</h5>
                                    <h2 class="mb-0">{{ $stats['total_donations'] ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Donasi Diklaim</h5>
                                    <h2 class="mb-0">{{ $stats['claimed_donations'] ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Donasi Tersedia</h5>
                                    <h2 class="mb-0">{{ $stats['available_donations'] ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Klaim Saya</h5>
                                    <h2 class="mb-0">{{ $stats['my_claims'] ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Donasi Terbaru Saya</h4>
                </div>
                <div class="card-body">
                    @if(count($recentDonations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Makanan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>                                    @foreach($recentDonations as $donation)
                                    <tr>
                                        <td>{{ $donation->food_name ?? 'N/A' }}</td>
                                        <td>{{ $donation->created_at->format('d M Y') }}</td>                                        <td>
                                            @if($donation->status == 'claimed')
                                                <span class="badge bg-success">Diklaim</span>
                                            @else
                                                <span class="badge bg-info">Tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="{{ route('donations.my') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Anda belum membuat donasi. <a href="{{ route('donate') }}">Buat donasi sekarang</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Klaim Terbaru Saya</h4>
                </div>
                <div class="card-body">
                    @if(count($recentClaims) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Makanan</th>
                                        <th>Donatur</th>
                                        <th>Tanggal Klaim</th>
                                    </tr>
                                </thead>
                                <tbody>                                    @foreach($recentClaims as $claim)
                                    <tr>
                                        <td>{{ $claim->donation->food_name ?? 'N/A' }}</td>
                                        <td>{{ $claim->donation->donor->username ?? 'N/A' }}</td>
                                        <td>{{ $claim->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="{{ route('claims.my') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Anda belum mengklaim donasi. <a href="{{ route('find-donations') }}">Cari donasi sekarang</a>.</p>
                        </div>
                    @endif
                </div>
            </div>        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p>Anda harus <a href="{{ route('login') }}">login</a> untuk melihat aktivitas.</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk aktivitas jika diperlukan
    });
</script>
@endsection
