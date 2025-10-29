@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<style>
.tour-booking-details .table td {
    padding: 0.5rem 0.75rem;
    border-top: 1px solid #dee2e6;
}
.tour-booking-details .table td:first-child {
    width: 35%;
    font-weight: 500;
    color: #6c757d;
}
.tour-booking-details .card {
    border: 1px solid #e3e6f0;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}
.swal2-popup {
    border-radius: 10px !important;
}
</style>

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

        <!-- Tour Booking Statistics Row -->
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <span class="badge badge-secondary p-3 me-3">
                                <i class="fas fa-route"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Total Tour Bookings</b></small>
                                </p>
                                <h2 class="mb-0">{{ $tourStats['total'] }}</h2>
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
                                <i class="fas fa-hourglass-half"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Pending Tours</b></small>
                                </p>
                                <h2 class="mb-0">{{ $tourStats['pending'] }}</h2>
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
                                <i class="fas fa-check-double"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Confirmed Tours</b></small>
                                </p>
                                <h2 class="mb-0">{{ $tourStats['confirmed'] }}</h2>
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
                                <i class="fas fa-coins"></i>
                            </span>
                            <div class="media-body">
                                <p class="mb-0 text-uppercase text-muted">
                                    <small><b>Tour Revenue</b></small>
                                </p>
                                <h2 class="mb-0">Rs {{ number_format($tourStats['revenue'], 0) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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

        <!-- Tour Bookings Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tour Package Bookings</h4>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-secondary me-2">Total: {{ $tourBookings->total() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($tourBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive-md border mb-0" style="border-radius: 8px;">
                                <thead>
                                    <tr>
                                        <th><strong>Booking Ref</strong></th>
                                        <th><strong>Guest</strong></th>
                                        <th><strong>Tour Package</strong></th>
                                        <th><strong>Date</strong></th>
                                        <th><strong>Participants</strong></th>
                                        <th><strong>Total</strong></th>
                                        <th><strong>Payment Status</strong></th>
                                        <th><strong>Actions</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tourBookings as $tourBooking)
                                    <tr>
                                        <td><strong class="text-primary">#{{ $tourBooking->booking_reference }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <p class="mb-0 font-w600">{{ $tourBooking->guest_name }}</p>
                                                    <p class="mb-0 text-muted">{{ $tourBooking->guest_email }}</p>
                                                    <small class="text-muted">{{ $tourBooking->guest_phone }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                @if($tourBooking->tourPackage)
                                                <p class="mb-0">{{ $tourBooking->tourPackage->name }}</p>
                                                <small class="text-muted">${{ number_format($tourBooking->tourPackage->price) }} per person</small>
                                                @else
                                                <p class="mb-0 text-muted">Package not found</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <p class="mb-0">{{ $tourBooking->tour_date->format('M d, Y') }}</p>
                                                <small class="text-muted">{{ $tourBooking->created_at->format('H:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-outline-primary">
                                                {{ $tourBooking->participants }} Participants
                                            </span>
                                        </td>
                                        <td><strong class="text-success">
                                            @if($tourBooking->tourPayment)
                                                ${{ number_format($tourBooking->tourPayment->total_amount) }}
                                            @else
                                                N/A
                                            @endif
                                        </strong></td>
                                        <td>
                                            @if($tourBooking->tourPayment)
                                                <span class="badge badge-{{ $tourBooking->tourPayment->payment_status === 'paid' ? 'success' : ($tourBooking->tourPayment->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($tourBooking->tourPayment->payment_status) }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">No Payment</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-info shadow btn-xs sharp me-1" 
                                                        onclick="viewTourBooking({{ $tourBooking->id }})" 
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                {{-- <!-- Email Actions Dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn btn-warning shadow btn-xs sharp me-1 dropdown-toggle" 
                                                            type="button" 
                                                            id="tourEmailDropdown{{ $tourBooking->id }}" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false"
                                                            title="Send Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="tourEmailDropdown{{ $tourBooking->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="#" 
                                                               onclick="sendTourEmail({{ $tourBooking->id }}, 'confirmation')">
                                                                <i class="fas fa-check-circle text-primary me-2"></i>
                                                                Booking Confirmation
                                                            </a>
                                                        </li>
                                                        @if($tourBooking->tourPayment && $tourBooking->tourPayment->payment_status === 'paid')
                                                        <li>
                                                            <a class="dropdown-item" href="#" 
                                                               onclick="sendTourEmail({{ $tourBooking->id }}, 'payment')">
                                                                <i class="fas fa-credit-card text-success me-2"></i>
                                                                Payment Confirmation
                                                            </a>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item" href="#" 
                                                               onclick="sendTourEmail({{ $tourBooking->id }}, 'status')">
                                                                <i class="fas fa-info-circle text-info me-2"></i>
                                                                Status Update
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                                
                                                <form action="{{ route('tour-bookings.destroy', $tourBooking->id) }}" method="POST"
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

                        <!-- Pagination for Tour Bookings -->
                        <div class="d-flex justify-content-between mt-3">
                            <div class="dataTables_paginate w-100">
                                {{ $tourBookings->links() }}
                            </div>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-route fa-3x text-muted"></i>
                            </div>
                            <h4>No Tour Bookings Found</h4>
                            <p class="text-muted">There are no tour package bookings in the system yet.</p>
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

// Function to view tour booking details
function viewTourBooking(id) {
    // Fetch tour booking details via AJAX
    fetch(`/admin/tour-bookings/${id}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const booking = data.booking;
                const tourPackage = booking.tour_package;
                const tourPayment = booking.tour_payment;
                
                // Format the payment status badge
                const paymentStatusBadge = tourPayment ? 
                    `<span class="badge badge-${tourPayment.payment_status === 'paid' ? 'success' : (tourPayment.payment_status === 'failed' ? 'danger' : 'warning')}">${tourPayment.payment_status ? tourPayment.payment_status.charAt(0).toUpperCase() + tourPayment.payment_status.slice(1) : 'N/A'}</span>` :
                    '<span class="badge badge-secondary">No Payment</span>';
                
                // Format the booking status badge
                const bookingStatusBadge = `<span class="badge badge-${booking.status === 'confirmed' ? 'success' : (booking.status === 'cancelled' ? 'danger' : 'warning')}">${booking.status ? booking.status.charAt(0).toUpperCase() + booking.status.slice(1) : 'N/A'}</span>`;
                
                const htmlContent = `
                    <div class="tour-booking-details">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3"><i class="fas fa-user text-primary me-2"></i>Guest Information</h5>
                                <table class="table table-sm">
                                    <tr><td class="text-start"><strong>Name:</strong></td><td>${booking.guest_name}</td></tr>
                                    <tr><td class="text-start"><strong>Email:</strong></td><td>${booking.guest_email}</td></tr>
                                    <tr><td class="text-start"><strong>Phone:</strong></td><td>${booking.guest_phone}</td></tr>
                                    <tr><td class="text-start"><strong>Address:</strong></td><td>${booking.guest_address}</td></tr>
                                    ${booking.guest_address_2 ? `<tr><td class="text-start"><strong>Address 2:</strong></td><td>${booking.guest_address_2}</td></tr>` : ''}
                                </table>
                                
                                <h5 class="mb-3 mt-4"><i class="fas fa-calendar-alt text-info me-2"></i>Booking Details</h5>
                                <table class="table table-sm">
                                    <tr><td class="text-start"><strong>Booking Ref:</strong></td><td>#${booking.booking_reference}</td></tr>
                                    <tr><td class="text-start"><strong>Tour Date:</strong></td><td>${new Date(booking.tour_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</td></tr>
                                    <tr><td class="text-start"><strong>Participants:</strong></td><td>${booking.participants} ${booking.participants === 1 ? 'Person' : 'People'}</td></tr>
                                    <tr><td class="text-start"><strong>Status:</strong></td><td>${bookingStatusBadge}</td></tr>
                                    <tr><td class="text-start"><strong>Booked On:</strong></td><td>${new Date(booking.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</td></tr>
                                </table>
                            </div>
                            
                            <div class="col-md-12">
                                <h5 class="mb-3 mt-4"><i class="fas fa-credit-card text-warning me-2"></i>Payment Information</h5>
                                <table class="table table-sm">
                                    ${tourPayment ? `
                                    <tr><td class="text-start"><strong>Payment Ref:</strong></td><td>#${tourPayment.payment_reference || 'N/A'}</td></tr>
                                    <tr><td class="text-start"><strong>Total Amount:</strong></td><td><strong class="text-success">$${tourPayment.total_amount ? new Intl.NumberFormat().format(tourPayment.total_amount) : 'N/A'}</strong></td></tr>
                                    <tr><td class="text-start"><strong>Payment Status:</strong></td><td>${paymentStatusBadge}</td></tr>
                                    ${tourPayment.payment_details && tourPayment.payment_details.payment_id ? `<tr><td class="text-start"><strong>Payment ID:</strong></td><td>${tourPayment.payment_details.payment_id}</td></tr>` : ''}
                                    ` : '<tr><td colspan="2" class="text-center text-muted">No payment record found</td></tr>'}
                                </table>
                            </div>
                        </div>
                        
                        ${booking.special_requests ? `
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3"><i class="fas fa-comment-alt text-secondary me-2"></i>Special Requests</h5>
                                <div class="alert alert-light">
                                    ${booking.special_requests}
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
                
                Swal.fire({
                    title: `<i class="fas fa-info-circle text-primary me-2"></i>Tour Booking Details`,
                    html: htmlContent,
                    width: '800px',
                    showCloseButton: true,
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fas fa-times me-2"></i>Close',
                    customClass: {
                        popup: 'text-left'
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to load tour booking details.',
                    icon: 'error',
                    confirmButtonText: 'Close'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Failed to fetch tour booking details. Please try again.',
                icon: 'error',
                confirmButtonText: 'Close'
            });
        });
}

// Tour Email Sending Function
// function sendTourEmail(bookingId, emailType) {
//     let route = '';
//     let emailTitle = '';
//     let confirmText = '';
    
//     switch(emailType) {
//         case 'confirmation':
//             route = `{{ url('/tour-bookings') }}/${bookingId}/send-confirmation`;
//             emailTitle = 'Send Booking Confirmation';
//             confirmText = 'Are you sure you want to send the booking confirmation email?';
//             break;
//         case 'payment':
//             route = `{{ url('/tour-bookings') }}/${bookingId}/send-payment-confirmation`;
//             emailTitle = 'Send Payment Confirmation';
//             confirmText = 'Are you sure you want to send the payment confirmation email?';
//             break;
//         case 'status':
//             route = `{{ url('/tour-bookings') }}/${bookingId}/send-status-update`;
//             emailTitle = 'Send Status Update';
//             confirmText = 'Are you sure you want to send the status update email?';
//             break;
//         default:
//             return;
//     }

//     Swal.fire({
//         title: emailTitle,
//         text: confirmText,
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, Send Email',
//         cancelButtonText: 'Cancel'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             // Show loading
//             Swal.fire({
//                 title: 'Sending Email...',
//                 text: 'Please wait while we send the email.',
//                 allowOutsideClick: false,
//                 allowEscapeKey: false,
//                 showConfirmButton: false,
//                 willOpen: () => {
//                     Swal.showLoading();
//                 }
//             });

//             // Send email request
//             fetch(route, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 }
//             })
//             .then(response => response.json())
//             .then(data => {
//                 Swal.close();
//                 if (data.success) {
//                     Swal.fire({
//                         title: 'Email Sent!',
//                         text: data.message || 'Email has been sent successfully.',
//                         icon: 'success',
//                         confirmButtonText: 'OK'
//                     });
//                 } else {
//                     throw new Error(data.message || 'Failed to send email');
//                 }
//             })
//             .catch(error => {
//                 Swal.close();
//                 console.error('Error:', error);
//                 Swal.fire({
//                     title: 'Error',
//                     text: 'Failed to send email. Please try again.',
//                     icon: 'error',
//                     confirmButtonText: 'Close'
//                 });
//             });
//         }
//     });
// }
</script>

@endsection