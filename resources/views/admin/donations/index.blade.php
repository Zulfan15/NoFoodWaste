@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Donations Management</h1>
        <a href="{{ route('admin.donations.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Donation
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Donations</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="donationsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Food Name</th>
                            <th>Quantity</th>
                            <th>Pickup Location</th>
                            <th>Expiration Date</th>
                            <th>Status</th>
                            <th>Donor</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->donation_id }}</td>
                            <td>{{ $donation->food_name }}</td>
                            <td>{{ $donation->quantity }}</td>
                            <td>{{ $donation->pickup_location }}</td>
                            <td>{{ $donation->expiration_date->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($donation->status == 'available')
                                    <span class="badge badge-success">Available</span>
                                @elseif($donation->status == 'claimed')
                                    <span class="badge badge-info">Claimed</span>
                                @else
                                    <span class="badge badge-danger">Expired</span>
                                @endif
                            </td>
                            <td>{{ $donation->donor->name ?? 'Unknown' }}</td>
                            <td>
                                <a href="{{ route('admin.donations.show', $donation->donation_id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.donations.edit', $donation->donation_id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.donations.destroy', $donation->donation_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donation?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#donationsTable').DataTable();
    });
</script>
@endsection
