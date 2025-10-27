@extends('layouts.public-site')

@section('content')

<style>
    .confirmation-card {
        max-width: 800px;
        margin: 0 auto;
    }

    .status-badge {
        font-size: 1.2em;
        padding: 0.5rem 1rem;
    }

    .font-serif,
    .font-serif p,
    .font-serif li {
        font-family: serif !important;
    }
</style>

<!--breadcrumb-->
<div class="breadcumb-banner">
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/drive-images-2-webp/kc21.webp') }}">
        <div
            style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
        </div>
        <div class="container relative" style="z-index: 10;">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Booking Confirmation</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li>Booking Confirmation</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="overflow-hidden space font-serif">
    <div class="container">
        <div class="confirmation-card" id="printableArea">
            @if(session('success'))
            <div class="alert alert-success text-center mb-4">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4>{{ session('success') }}</h4>
            </div>
            @endif

            <form id="payForm" action="/booking/{{ $booking->id }}/payment" method="POST">
                @csrf
            </form>

            <div class="card">
                <div class="card-header text-center">
                    <h3 class="mb-0">
                        <i class="fas fa-calendar-check me-2 text-success"></i>
                        Booking Confirmed
                    </h3>
                    <p class="text-muted mb-0">Reference: <strong class="text-primary">#{{ $booking->booking_reference
                            }}</strong></p>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Guest Information -->
                        <div class="col-md-6 mb-4">
                            <h5><i class="fas fa-user me-2"></i>Guest Information</h5>
                            <div class="ps-3">
                                <p class="mb-1"><strong>Name:</strong> {{ $booking->guest_name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $booking->guest_email }}</p>
                                <p class="mb-1"><strong>Phone:</strong> {{ $booking->guest_phone }}</p>
                                @if($booking->guest_address)
                                <p class="mb-1"><strong>Address:</strong> {{ $booking->guest_address }}</p>
                                @endif
                                @if($booking->guest_address_2)
                                <p class="mb-1"><strong>Address 2:</strong> {{ $booking->guest_address_2 }}</p>
                                @endif
                                <p class="mb-0"><strong>Guests:</strong> {{ $booking->adults }} Adults
                                    @if($booking->children > 0), {{ $booking->children }} Children @endif
                                </p>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="col-md-6 mb-4">
                            <h5><i class="fas fa-bed me-2"></i>Room Details</h5>
                            <div class="ps-3">
                                <p class="mb-1"><strong>Room Type:</strong> {{ $booking->roomType->name }}</p>
                                <p class="mb-1"><strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y')
                                    }}</p>
                                <p class="mb-1"><strong>Check-out:</strong> {{ $booking->check_out_date->format('M d,
                                    Y') }}</p>
                                <p class="mb-0"><strong>Nights:</strong> {{ $booking->nights }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status and Payment -->
                    <div class="row mb-4">
                        <div class="col-md-6 d-flex">
                            <h5><i class="fas fa-info-circle me-2"></i>Status</h5>
                            <div class="ps-3">
                                <span class="p-1 text-white bg-{{ $booking->status_badge }}">
                                    <small>{{ ucfirst($booking->status) }}</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-credit-card me-2"></i>Payment Status</h5>
                            <div class="ps-3">
                                <p class="mb-2">
                                    <span
                                        class="p-1 text-white bg-{{ $booking->payment->payment_status === 'paid' ? 'success' : ($booking->payment->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->payment->payment_status) }}
                                    </span>
                                </p>
                                @if($booking->payment->payment_reference)
                                <small class="text-muted">Ref: {{ $booking->payment->payment_reference }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Total Amount</h5>
                                        <small>{{ $booking->roomType->formatted_price }} × {{ $booking->nights }}
                                            nights</small>
                                    </div>
                                    <h3 class="mb-0 text-success">{{ $booking->formatted_total }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    @if($booking->special_requests)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5><i class="fas fa-comment me-2"></i>Special Requests</h5>
                            <div class="ps-3">
                                <p class="mb-0">{{ $booking->special_requests }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="text-center">
                        @if($booking->payment->payment_status === 'pending')
                        <button class="btn btn-success me-2" onclick="processPayment()">
                            <i class="fas fa-credit-card me-2"></i>Pay Now
                        </button>
                        @endif

                        <a href="/" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>

                        <button class="btn btn-outline-secondary ms-2" onclick="printInfo()">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Important Information</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Please arrive at the hotel after 2:00 PM on your check-in date.</li>
                        <li>Check-out time is 11:00 AM.</li>
                        <li>Valid photo ID is required at check-in.</li>
                        <li>For any changes or cancellations, please contact us at least 24 hours in advance.</li>
                        <li>Payment must be completed to confirm your reservation.</li>
                    </ul>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <h5>Need Help?</h5>
                    <p class="mb-2">Contact us for any questions about your booking:</p>
                    <p class="mb-0">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:+94767799721">+94 76 779 9721</a>
                        <span class="mx-3">|</span>
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:reservations@kingscastle.com">reservations@kingscastle.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function printInfo() {
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function processPayment() {
        // Show loading state
        const payButton = document.querySelector('.btn-success');
        const originalText = payButton.innerHTML;
        payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        payButton.disabled = true;

        document.getElementById('payForm').submit();
    }
</script>

@endsection