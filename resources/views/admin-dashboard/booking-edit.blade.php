@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-marker {
        position: absolute;
        left: -38px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #e9ecef;
    }

    .timeline-content h6 {
        margin-bottom: 5px;
        color: #495057;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Booking #{{ $booking->booking_reference }}</h4>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('booking.update', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Guest Information (Read-only) -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Guest Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Name:</strong> {{ $booking->guest_name }}</p>
                                            <p><strong>Email:</strong> {{ $booking->guest_email }}</p>
                                            <p><strong>Phone:</strong> {{ $booking->guest_phone }}</p>
                                            @if($booking->guest_address)
                                            <p><strong>Address:</strong> {{ $booking->guest_address }}</p>
                                            @endif
                                            @if($booking->guest_address_2)
                                            <p><strong>Address 2:</strong> {{ $booking->guest_address_2 }}</p>
                                            @endif
                                            <p><strong>Guests:</strong> {{ $booking->adults }} Adults
                                                @if($booking->children > 0), {{ $booking->children }} Children @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Booking Details (Read-only) -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Booking Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                <strong>Room Type:</strong>
                                                @if($booking->roomTypes->count() > 0)
                                                @foreach($booking->roomTypes as $roomType)
                                                <p class="mb-0">{{ $roomType->name }}</p>
                                                <small class="text-muted">{{ $roomType->formatted_price }}/night</small>
                                                @if(!$loop->last)<br>@endif
                                                @endforeach
                                                @else
                                                <p class="mb-0 text-muted">No rooms selected</p>
                                                @endif
                                            </p>
                                            <p><strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y')
                                                }}</p>
                                            <p><strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y')
                                                }}</p>
                                            <p><strong>Nights:</strong> {{ $booking->nights }}</p>
                                            <p><strong>Total Amount:</strong> {{ $booking->formatted_total }}</p>
                                            <p><strong>Booked on:</strong> {{ $booking->created_at->format('M d, Y H:i')
                                                }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <!-- Editable Fields -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Update Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Booking Status</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="pending" {{ $booking->status === 'pending' ?
                                                        'selected' : '' }}>Pending</option>
                                                    <option value="confirmed" {{ $booking->status === 'confirmed' ?
                                                        'selected' : '' }}>Confirmed</option>
                                                    <option value="checked_in" {{ $booking->status === 'checked_in' ?
                                                        'selected' : '' }}>Checked In</option>
                                                    <option value="checked_out" {{ $booking->status === 'checked_out' ?
                                                        'selected' : '' }}>Checked Out</option>
                                                    <option value="cancelled" {{ $booking->status === 'cancelled' ?
                                                        'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="payment_status" class="form-label">Payment Status</label>
                                                <select name="payment_status" id="payment_status" class="form-select"
                                                    required>
                                                    <option value="pending" {{ $booking->payment->payment_status === 'pending' ?
                                                        'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ $booking->payment->payment_status === 'paid' ?
                                                        'selected' : '' }}>Paid</option>
                                                    <option value="failed" {{ $booking->payment->payment_status === 'failed' ?
                                                        'selected' : '' }}>Failed</option>
                                                </select>
                                            </div>

                                            @if($booking->payment_reference)
                                            <div class="mb-3">
                                                <label class="form-label">Payment Reference</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $booking->payment_reference }}" readonly>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Special Requests & Notes</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="special_requests" class="form-label">Special
                                                    Requests</label>
                                                <textarea name="special_requests" id="special_requests"
                                                    class="form-control"
                                                    rows="4">{{ old('special_requests', $booking->special_requests) }}</textarea>
                                                @error('special_requests')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Booking
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking History/Activity -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Booking Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6>Booking Created</h6>
                                    <p class="mb-0">{{ $booking->created_at->format('M d, Y H:i A') }}</p>
                                </div>
                            </div>

                            @if($booking->payment->payment_status === 'paid')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6>Payment Completed</h6>
                                    <p class="mb-0">{{ $booking->updated_at->format('M d, Y H:i A') }}</p>
                                    @if($booking->payment->payment_reference)
                                    <small class="text-muted">Reference: {{ $booking->payment->payment_reference }}</small>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($booking->status === 'confirmed')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6>Booking Confirmed</h6>
                                    <p class="mb-0">{{ $booking->updated_at->format('M d, Y H:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($booking->status === 'checked_in')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6>Guest Checked In</h6>
                                    <p class="mb-0">{{ $booking->check_in_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($booking->status === 'checked_out')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6>Guest Checked Out</h6>
                                    <p class="mb-0">{{ $booking->check_out_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection