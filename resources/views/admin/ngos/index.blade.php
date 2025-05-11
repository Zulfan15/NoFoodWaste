@extends('layouts.admin')

@section('title', 'NGO Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>NGO Management</h2>
                <a href="{{ route('admin.ngos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New NGO
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
            <h4 class="card-title">NGOs List</h4>
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
                        @forelse($ngos as $ngo)
                        <tr>
                            <td>{{ $ngo->user_id }}</td>
                            <td>{{ $ngo->username }}</td>
                            <td>{{ $ngo->email }}</td>
                            <td>{{ $ngo->phone_number ?? 'N/A' }}</td>
                            <td>{{ $ngo->address ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.ngos.show', $ngo->user_id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ngos.edit', $ngo->user_id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.ngos.destroy', $ngo->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this NGO?');">
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
                            <td colspan="6" class="text-center">No NGOs found</td>
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
