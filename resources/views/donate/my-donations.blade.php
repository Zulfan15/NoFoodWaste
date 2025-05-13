@extends('layouts.admin.master')

@section('title', 'Donasi Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Donasi Saya</h4>
                    <a href="{{ route('donate') }}" class="btn btn-primary">Buat Donasi Baru</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(count($donations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Makanan</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Kedaluwarsa</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donations as $donation)
                                    <tr>
                                        <td>{{ $donation->donation_id }}</td>
                                        <td>{{ $donation->food_name }}</td>
                                        <td>{{ $donation->quantity }}</td>
                                        <td>{{ \Carbon\Carbon::parse($donation->expiration_date)->format('d M Y') }}</td>
                                        <td>
                                            @if($donation->status == 'claimed')
                                                <span class="badge bg-success">Diklaim</span>
                                            @else
                                                <span class="badge bg-info">Tersedia</span>
                                            @endif
                                        </td>
                                        <td>{{ $donation->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('donations.show', $donation->donation_id) }}" class="btn btn-sm btn-info">Detail</a>
                                            @if($donation->status != 'claimed')
                                                <a href="{{ route('donations.edit', $donation->donation_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDonationModal{{ $donation->donation_id }}">
                                                    Hapus
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteDonationModal{{ $donation->donation_id }}" tabindex="-1" aria-labelledby="deleteDonationModalLabel{{ $donation->donation_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('donations.destroy', $donation->donation_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteDonationModalLabel{{ $donation->donation_id }}">Konfirmasi Hapus</h5>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $donations->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Anda belum membuat donasi apapun. <a href="{{ route('donate') }}">Buat donasi sekarang</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
