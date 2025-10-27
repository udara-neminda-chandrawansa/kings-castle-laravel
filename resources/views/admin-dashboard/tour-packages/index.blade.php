@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<div class="content-body">
    <div class="container-fluid">

        <!-- Tour Package Statistics Row -->
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-primary p-3 me-3">
                                <i class="fas fa-route"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Total Packages</b></small>
                                </p>
                                <h2 class="mb-0">{{ $tourPackages->total() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-success p-3 me-3">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Active (within this page)</b></small>
                                </p>
                                <h2 class="mb-0">{{ $tourPackages->where('is_active', true)->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-warning p-3 me-3">
                                <i class="fas fa-pause-circle"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Inactive (within this page)</b></small>
                                </p>
                                <h2 class="mb-0">{{ $tourPackages->where('is_active', false)->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-info p-3 me-3">
                                <i class="fas fa-clock"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Avg Duration (within this page)</b></small>
                                </p>
                                <h2 class="mb-0 small">{{ $tourPackages->pluck('duration')->unique()->implode(', ') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tour Packages Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tour Packages Management</h4>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('tour-packages.create') }}" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-plus me-1"></i>Add New Package
                            </a>
                            <span class="badge badge-primary">Total: {{ $tourPackages->total() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if($tourPackages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-md border mb-0" style="border-radius: 8px;">
                                    <thead>
                                        <tr>
                                            <th><strong>Package</strong></th>
                                            <th><strong>Description</strong></th>
                                            <th><strong>Price</strong></th>
                                            <th><strong>Duration</strong></th>
                                            <th><strong>Difficulty</strong></th>
                                            <th><strong>Participants</strong></th>
                                            <th><strong>Status</strong></th>
                                            <th><strong>Actions</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tourPackages as $package)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset($package->image_path) }}" alt="{{ $package->name }}" 
                                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div>
                                                            <p class="mb-0 font-w600">{{ $package->name }}</p>
                                                            <small class="text-muted">{{ $package->subtitle }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-wrap" style="max-width: 200px;">
                                                        {{ Str::limit($package->description, 80) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($package->price)
                                                        <strong class="text-success">${{ number_format($package->price) }}</strong>
                                                        <br><small class="text-muted">{{ $package->price_unit }}</small>
                                                    @else
                                                        <span class="text-muted">Contact for price</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-outline-info">{{ $package->duration }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $package->difficulty_level == 'easy' ? 'success' : ($package->difficulty_level == 'moderate' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($package->difficulty_level) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-outline-primary">
                                                        {{ $package->min_participants }}-{{ $package->max_participants }} pax
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $package->is_active ? 'success' : 'warning' }}">
                                                        {{ $package->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('tour-packages.edit', $package) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('tour-packages.toggle-status', $package) }}" method="POST" class="d-inline me-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-{{ $package->is_active ? 'warning' : 'success' }} shadow btn-xs sharp" 
                                                                    title="{{ $package->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <i class="fas fa-{{ $package->is_active ? 'pause' : 'play' }}"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('tour-packages.destroy', $package) }}" method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger shadow btn-xs sharp delete-btn">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between">
                                <div class="dataTables_paginate w-100 mt-3">
                                    {{ $tourPackages->links() }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-route fa-3x text-muted"></i>
                                </div>
                                <h4>No Tour Packages Found</h4>
                                <p class="text-muted">There are no tour packages in the system yet.</p>
                                <a href="{{ route('tour-packages.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add First Package
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete confirmation with SweetAlert2
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this tour package? This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
