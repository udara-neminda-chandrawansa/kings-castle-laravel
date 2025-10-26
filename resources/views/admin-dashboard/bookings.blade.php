@extends('layouts.admin-dashboard')

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
                                    <small><b>Pending</b></small>
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
                                    <small><b>Confirmed</b></small>
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
                                    <small><b>Revenue (Paid)</b></small>
                                </p>
                                <h2 class="mb-0">Rs {{ number_format($bookings->where('payment_status', 'paid')->sum('total_amount'), 0) }}</h2>
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
                                <table class="table table-responsive-md">
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
                                                <td><strong class="text-primary">#{{ $booking->booking_reference }}</strong></td>
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
                                                        <p class="mb-0">{{ $booking->roomType->name }}</p>
                                                        <small class="text-muted">{{ $booking->roomType->formatted_price }}/night</small>
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
                                                    <span class="badge badge-{{ $booking->payment_status === 'paid' ? 'success' : ($booking->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($booking->payment_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('booking.edit', $booking) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <form action="{{ route('booking.destroy', $booking) }}" method="POST" class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger shadow btn-xs sharp">
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
                                <div class="dataTables_info">
                                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries
                                </div>
                                <div class="dataTables_paginate">
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

@endsection