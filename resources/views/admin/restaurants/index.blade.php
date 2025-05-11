@extends('layouts.admin')

@section('title', 'Restaurant Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Restaurant Management</h2>
                <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Restaurant
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Restaurants List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($restaurants as $restaurant)
                        <tr>
                            <td>{{ $restaurant->user_id }}</td>
                            <td>{{ $restaurant->username }}</td>
                            <td>{{ $restaurant->email }}</td>
                            <td>{{ $restaurant->phone_number ?? 'N/A' }}</td>
                            <td>{{ $restaurant->address ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.restaurants.show', $restaurant->user_id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.restaurants.edit', $restaurant->user_id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.restaurants.destroy', $restaurant->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this restaurant?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No restaurants found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any needed JavaScript here
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const closeBtn = new bootstrap.Alert(alert);
                closeBtn.close();
            }, 5000);
        });
    });
</script>
@endsection
