@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<div class="content-body">
    <div class="container-fluid">

        <!-- Room Type Statistics Row -->
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-primary p-3 me-3">
                                <i class="fas fa-bed"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Total Room Types</b></small>
                                </p>
                                <h2 class="mb-0">{{ $roomTypes->total() }}</h2>
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
                                    <small><b>Active</b></small>
                                </p>
                                <h2 class="mb-0">{{ $roomTypes->where('is_active', true)->count() }}</h2>
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
                                    <small><b>Inactive</b></small>
                                </p>
                                <h2 class="mb-0">{{ $roomTypes->where('is_active', false)->count() }}</h2>
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
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Avg Price/Night</b></small>
                                </p>
                                <h2 class="mb-0">Rs {{ number_format($roomTypes->avg('price_per_night'), 0) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Types Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Room Types Management</h4>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('room-types.create') }}" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-plus me-1"></i>Add New Room Type
                            </a>
                            <span class="badge badge-primary">Total: {{ $roomTypes->total() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if($roomTypes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-md border mb-0" style="border-radius: 8px;">
                                    <thead>
                                        <tr>
                                            <th><strong>Room Type</strong></th>
                                            <th><strong>Description</strong></th>
                                            <th><strong>Price/Night</strong></th>
                                            <th><strong>Max Occupancy</strong></th>
                                            <th><strong>Amenities</strong></th>
                                            <th><strong>Bookings</strong></th>
                                            <th><strong>Status</strong></th>
                                            <th><strong>Actions</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roomTypes as $roomType)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" 
                                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div>
                                                            <p class="mb-0 font-w600">{{ $roomType->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-wrap" style="max-width: 200px;">
                                                        {{ Str::limit($roomType->description, 80) }}
                                                    </div>
                                                </td>
                                                <td><strong class="text-success">{{ $roomType->formatted_price }}</strong></td>
                                                <td>
                                                    <span class="badge badge-outline-info">
                                                        {{ $roomType->max_occupancy }} 
                                                        {{ $roomType->max_occupancy == 1 ? 'Guest' : 'Guests' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($roomType->amenities && count($roomType->amenities) > 0)
                                                        @foreach(array_slice($roomType->amenities, 0, 2) as $amenity)
                                                            <small class="badge badge-light me-1">{{ $amenity }}</small>
                                                        @endforeach
                                                        @if(count($roomType->amenities) > 2)
                                                            <small class="text-muted">+{{ count($roomType->amenities) - 2 }} more</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No amenities</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-outline-primary">
                                                        {{ $roomType->bookings_count }} 
                                                        {{ $roomType->bookings_count == 1 ? 'Booking' : 'Bookings' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $roomType->is_active ? 'success' : 'warning' }}">
                                                        {{ $roomType->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-primary shadow btn-xs sharp me-1"
                                                           title="Edit Room Type">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('room-images.index', $roomType) }}" class="btn btn-info shadow btn-xs sharp me-1"
                                                           title="Manage Gallery Images">
                                                            <i class="fas fa-images"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('room-types.toggle-status', $roomType) }}" method="POST" class="d-inline me-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-{{ $roomType->is_active ? 'warning' : 'success' }} shadow btn-xs sharp" 
                                                                    title="{{ $roomType->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <i class="fas fa-{{ $roomType->is_active ? 'pause' : 'play' }}"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        @if($roomType->bookings_count == 0)
                                                            <form action="{{ route('room-types.destroy', $roomType) }}" method="POST" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger shadow btn-xs sharp delete-btn">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-danger shadow btn-xs sharp" disabled 
                                                                    title="Cannot delete room type with existing bookings">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between">
                                <div class="dataTables_paginate w-100">
                                    {{ $roomTypes->links() }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                </div>
                                <h4>No Room Types Found</h4>
                                <p class="text-muted">There are no room types in the system yet.</p>
                                <a href="{{ route('room-types.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add First Room Type
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
                text: 'You want to delete this room type? This action cannot be undone!',
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
