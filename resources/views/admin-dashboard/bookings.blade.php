@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<div class="content-body">
    <div class="container-fluid">

        <!-- Booking Statistics Row -->
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-primary p-3 me-3">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Total Bookings</b></small>
                                </p>
                                <h2 class="mb-0">{{ $bookings->total() }}</h2>
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
                                <i class="fas fa-clock"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Pending (within this page)</b></small>
                                </p>
                                <h2 class="mb-0">{{ $bookings->where('status', 'pending')->count() }}</h2>
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
                                    <small><b>Confirmed (within this page)</b></small>
                                </p>
                                <h2 class="mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h2>
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
                                    <small><b>Revenue (within this page)</b></small>
                                </p>
                                <h2 class="mb-0">Rs {{ number_format($bookings->filter(function($booking) { return
                                    $booking->payment && $booking->payment->payment_status == 'paid';
                                    })->sum(function($booking) { return $booking->payment->total_amount; }), 0) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hotel Bookings</h4>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary me-2">Total: {{ $bookings->total() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive-md border mb-0"
                                style="border-radius: 8px;">
                                <thead>
                                    <tr>
                                        <th><strong>Booking Ref</strong></th>
                                        <th><strong>Guest</strong></th>
                                        <th><strong>Room Type</strong></th>
                                        <th><strong>Dates</strong></th>
                                        <th><strong>Guests</strong></th>
                                        <th><strong>Total</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong>Payment</strong></th>
                                        <th><strong>Actions</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td><strong class="text-primary">#{{ $booking->booking_reference }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <p class="mb-0 font-w600">{{ $booking->guest_name }}</p>
                                                    <p class="mb-0 text-muted">{{ $booking->guest_email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                @if($booking->roomTypes->count() > 0)
                                                @foreach($booking->roomTypes as $roomType)
                                                <p class="mb-0">{{ $roomType->name }}</p>
                                                <small class="text-muted">{{ $roomType->formatted_price }}/night</small>
                                                @if(!$loop->last)<br>@endif
                                                @endforeach
                                                @else
                                                <p class="mb-0 text-muted">No rooms selected</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <p class="mb-0">{{ $booking->check_in_date->format('M d, Y') }}</p>
                                                <p class="mb-0">{{ $booking->check_out_date->format('M d, Y') }}</p>
                                                <small class="text-muted">{{ $booking->nights }} nights</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-outline-info">
                                                {{ $booking->adults }} Adults
                                                @if($booking->children > 0)
                                                , {{ $booking->children }} Children
                                                @endif
                                            </span>
                                        </td>
                                        <td><strong class="text-success">{{ $booking->formatted_total }}</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $booking->status_badge }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                            $status = $booking->payment?->payment_status;
                                            @endphp

                                            <span
                                                class="badge badge-{{ $status === 'paid' ? 'success' : ($status === 'failed' ? 'danger' : 'warning') }}">
                                                {{ $status ? ucfirst($status) : 'Pending' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('booking.edit', $booking) }}"
                                                    class="btn btn-primary shadow btn-xs sharp me-1"
                                                    title="Edit Booking">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                
                                                <!-- Email Actions Dropdown -->
                                                {{-- <div class="dropdown me-1">
                                                    <button class="btn btn-info shadow btn-xs sharp" type="button" 
                                                            data-bs-toggle="dropdown" aria-expanded="false" title="Send Emails">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="{{ route('booking.send-confirmation', $booking->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item email-btn">
                                                                    <i class="fas fa-calendar-check me-2"></i>Booking Confirmation
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @if($booking->payment && $booking->payment->payment_status === 'paid')
                                                        <li>
                                                            <form action="{{ route('booking.send-payment-confirmation', $booking->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item email-btn">
                                                                    <i class="fas fa-credit-card me-2"></i>Payment Confirmation
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <form action="{{ route('booking.send-status-update', $booking->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item email-btn">
                                                                    <i class="fas fa-bell me-2"></i>Status Update
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div> --}}

                                                <form action="{{ route('booking.destroy', $booking) }}" method="POST"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-danger shadow btn-xs sharp delete-btn"
                                                        title="Delete Booking">
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
                            <div class="dataTables_paginate w-100">
                                {{ $bookings->links() }}

                            </div>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-times fa-3x text-muted"></i>
                            </div>
                            <h4>No Bookings Found</h4>
                            <p class="text-muted">There are no bookings in the system yet.</p>
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
                text: 'You want to delete this booking? This action cannot be undone!',
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

    // Handle email button clicks with loading state
    // document.querySelectorAll('.email-btn').forEach(function(button) {
    //     button.addEventListener('click', function(e) {
    //         // Show loading state
    //         const originalContent = this.innerHTML;
    //         this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    //         this.disabled = true;
            
    //         // Submit the form
    //         const form = this.closest('form');
            
    //         // Reset button state after a delay (in case of redirect)
    //         setTimeout(() => {
    //             if (this) {
    //                 this.innerHTML = originalContent;
    //                 this.disabled = false;
    //             }
    //         }, 3000);
    //     });
    // });
});
</script>

@endsection