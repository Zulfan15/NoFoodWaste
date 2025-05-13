@extends('layouts.admin.master')

@section('title', 'Klaim Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Klaim Donasi Saya</h4>
                    <a href="{{ route('find-donations') }}" class="btn btn-primary">Cari Donasi Baru</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(count($claims) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Klaim</th>
                                        <th>Nama Makanan</th>
                                        <th>Donatur</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal Klaim</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claims as $claim)                                    <tr>                                        <td>{{ $claim->claim_id }}</td>
                                        <td>{{ $claim->donation->food_name ?? 'N/A' }}</td>
                                        <td>{{ $claim->donation && $claim->donation->donor ? $claim->donation->donor->username : 'Pengguna Tidak Diketahui' }}</td>
                                        <td>{{ $claim->donation->quantity ?? 'N/A' }}</td>
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
                                        <td>{{ $claim->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('claims.show', $claim->claim_id) }}" class="btn btn-sm btn-info">Detail</a>
                                            @if($claim->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelClaimModal{{ $claim->claim_id }}">
                                                    Batalkan
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <!-- Cancel Modal -->
                                    <div class="modal fade" id="cancelClaimModal{{ $claim->claim_id }}" tabindex="-1" aria-labelledby="cancelClaimModalLabel{{ $claim->claim_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('claims.cancel', $claim->claim_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="cancelClaimModalLabel{{ $claim->claim_id }}">Konfirmasi Pembatalan</h5>                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin membatalkan klaim untuk donasi <strong>{{ $claim->donation && $claim->donation->food_name ? $claim->donation->food_name : 'Tidak Diketahui' }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $claims->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Anda belum mengklaim donasi apapun. <a href="{{ route('find-donations') }}">Cari donasi sekarang</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
