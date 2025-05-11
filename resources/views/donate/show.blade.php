@extends('layouts.admin.master')

@section('title', 'Detail Donasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Donasi</h4>
                    <div>
                        @if(Auth::id() == $donation->user_id)
                            <a href="{{ route('donations.my') }}" class="btn btn-secondary">Kembali ke Donasi Saya</a>
                            @if(!$donation->is_claimed)
                                <a href="{{ route('donations.edit', $donation->donation_id) }}" class="btn btn-warning">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDonationModal">
                                    Hapus
                                </button>
                            @endif
                        @else
                            <a href="{{ route('find-donations') }}" class="btn btn-secondary">Kembali ke Pencarian</a>
                            @if(!$donation->is_claimed)
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#claimDonationModal">
                                    Klaim Donasi
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
                            <h5 class="mb-4">Informasi Donasi</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID Donasi</th>
                                    <td>{{ $donation->donation_id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Makanan</th>
                                    <td>{{ $donation->food_name }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $donation->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kedaluwarsa</th>
                                    <td>{{ \Carbon\Carbon::parse($donation->expiry_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($donation->is_claimed)
                                            <span class="badge bg-success">Diklaim</span>
                                        @else
                                            <span class="badge bg-info">Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lokasi Pengambilan</th>
                                    <td>{{ $donation->pickup_location }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $donation->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-4">Informasi Donatur</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $donation->user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $donation->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $donation->user->phone_number ?? 'Tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $donation->user->address ?? 'Tidak tersedia' }}</td>
                                </tr>
                            </table>
                            
                            @if($donation->is_claimed && isset($donation->claims) && count($donation->claims) > 0)
                                <h5 class="mt-4 mb-4">Informasi Penerima</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Nama</th>
                                        <td>{{ $donation->claims[0]->user->username }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $donation->claims[0]->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>{{ $donation->claims[0]->user->phone_number ?? 'Tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Klaim</th>
                                        <td>
                                            @if($donation->claims[0]->status == 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($donation->claims[0]->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($donation->claims[0]->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($donation->claims[0]->status == 'completed')
                                                <span class="badge bg-primary">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(Auth::id() == $donation->user_id && !$donation->is_claimed)
<div class="modal fade" id="deleteDonationModal" tabindex="-1" aria-labelledby="deleteDonationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('donations.destroy', $donation->donation_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDonationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus donasi <strong>{{ $donation->food_name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Claim Modal -->
@if(Auth::id() != $donation->user_id && !$donation->is_claimed)
<div class="modal fade" id="claimDonationModal" tabindex="-1" aria-labelledby="claimDonationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('donations.claim', $donation->donation_id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="claimDonationModalLabel">Klaim Donasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan mengklaim donasi <strong>{{ $donation->food_name }}</strong>.</p>
                    <p>Pastikan Anda telah membaca semua detail donasi dan setuju untuk mengambil makanan di lokasi yang ditentukan.</p>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan untuk donatur..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Klaim Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
