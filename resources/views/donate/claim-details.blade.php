@extends('layouts.admin.master')

@section('title', 'Detail Klaim')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Klaim</h4>
                    <div>
                        @if(Auth::id() == $claim->user_id)
                            <a href="{{ route('claims.my') }}" class="btn btn-secondary">Kembali ke Klaim Saya</a>
                            @if($claim->status == 'pending')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelClaimModal">
                                    Batalkan Klaim
                                </button>
                            @endif
                        @else
                            <a href="{{ route('donations.my') }}" class="btn btn-secondary">Kembali ke Donasi Saya</a>
                            @if($claim->status == 'pending')
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveClaimModal">
                                    Setujui
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectClaimModal">
                                    Tolak
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-4">Informasi Klaim</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID Klaim</th>
                                    <td>{{ $claim->claim_id }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($claim->status == 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($claim->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($claim->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($claim->status == 'completed')
                                            <span class="badge bg-primary">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Klaim</th>
                                    <td>{{ $claim->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $claim->notes ?? 'Tidak ada catatan' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-4">Informasi Donasi</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Makanan</th>
                                    <td>{{ $claim->donation->food_name }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $claim->donation->quantity }}</td>
                                </tr>                                <tr>
                                    <th>Donatur</th>
                                    <td>{{ $claim->donation->donor->username }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi Pengambilan</th>
                                    <td>{{ $claim->donation->pickup_location }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kedaluwarsa</th>
                                    <td>{{ \Carbon\Carbon::parse($claim->donation->expiration_date)->format('d M Y') }}</td>
                                </tr>
                            </table>
                            
                            <h5 class="mt-4 mb-4">Detail Kontak</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Donatur</th>
                                    <td>
                                        <strong>{{ optional($claim->donation->user)->username ?? '-' }}</strong><br>
                                        Email: {{ optional($claim->donation->user)->email ?? '-' }}<br>
                                        Telepon: {{ $claim->donation->user->phone_number ?? 'Tidak tersedia' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Penerima</th>
                                    <td>
                                        <strong>{{ optional($claim->user)->username ?? '-' }}</strong><br>
                                        Email: {{ optional($claim->user)->email ?? '-' }}<br>
                                        Telepon: {{ $claim->user->phone_number ?? 'Tidak tersedia' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Claim Modal -->
@if(Auth::id() == $claim->user_id && $claim->status == 'pending')
<div class="modal fade" id="cancelClaimModal" tabindex="-1" aria-labelledby="cancelClaimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('claims.cancel', $claim->claim_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelClaimModalLabel">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan klaim untuk donasi <strong>{{ $claim->donation->food_name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Owner actions modals - For future implementation -->
@if(Auth::id() == $claim->donation->user_id && $claim->status == 'pending')
<div class="modal fade" id="approveClaimModal" tabindex="-1" aria-labelledby="approveClaimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveClaimModalLabel">Setujui Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Fitur ini akan diimplementasikan pada update berikutnya.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectClaimModal" tabindex="-1" aria-labelledby="rejectClaimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectClaimModalLabel">Tolak Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Fitur ini akan diimplementasikan pada update berikutnya.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
