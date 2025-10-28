@extends('layouts.public-site')

@section('content')

<!--breadcrumb-->
<div class="breadcumb-banner">
    <div class="breadcumb-wrapper" data-bg-src="/assets/img/drive-images-2-webp/kc5.webp">
        <div
            style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
        </div>
        <div class="container" style="position: relative; z-index: 10;">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Tour Booking Confirmation</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/packages">Tour Packages</a></li>
                    <li>Booking Confirmation</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--booking confirmation-->
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="booking-confirmation-card">
                    <div class="confirmation-header text-center mb-40">
                        <div class="success-icon mb-20">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="box-title">Tour Booking Confirmed!</h2>
                        <p class="text-muted">Thank you for booking with King's Castle. Your tour reservation has been
                            confirmed.</p>
                    </div>

                    <div class="booking-details">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-card">
                                    <h4 class="box-title mb-20">Booking Information</h4>
                                    <ul class="booking-info-list" style="line-height: 2.5;">
                                        <li><strong>Booking ID:</strong> #{{ $tourPayment->id }}</li>
                                        <li><strong>Tour Package:</strong> {{ $tourPayment->tourPackage->name }}</li>
                                        <li><strong>Tour Date:</strong> {{ $tourPayment->tour_date->format('F j, Y') }}
                                        </li>
                                        <li><strong>Participants:</strong> {{ $tourPayment->participants }}</li>
                                        <li><strong>Total Amount:</strong> <span class="text-theme">{{
                                                $tourPayment->formatted_total }}</span></li>
                                        <li><strong>Status:</strong>
                                            <span
                                                class="ms-1 p-1 text-white bg-{{ $tourPayment->status == 'confirmed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($tourPayment->status) }}
                                            </span>
                                        </li>
                                        <li><strong>Payment Status:</strong>
                                            <span
                                                class="ms-1 p-1 text-white bg-{{ $tourPayment->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($tourPayment->payment_status) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-card">
                                    <h4 class="box-title mb-20">Guest Information</h4>
                                    <ul class="booking-info-list" style="line-height: 2.5;">
                                        <li><strong>Name:</strong> {{ $tourPayment->guest_name }}</li>
                                        <li><strong>Email:</strong> {{ $tourPayment->guest_email }}</li>
                                        <li><strong>Phone:</strong> {{ $tourPayment->guest_phone }}</li>
                                        <li><strong>Address:</strong> {{ $tourPayment->guest_address }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if($tourPayment->special_requests)
                        <div class="row mt-30">
                            <div class="col-12">
                                <div class="detail-card">
                                    <h4 class="box-title mb-20">Special Requests</h4>
                                    <p class="box-text">{{ $tourPayment->special_requests }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row mt-30">
                            <div class="col-12">
                                <div class="detail-card">
                                    <h4 class="box-title mb-20">Tour Package Details</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ asset($tourPayment->tourPackage->image_path) }}"
                                                alt="{{ $tourPayment->tourPackage->name }}" class="img-fluid rounded">
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="box-title">{{ $tourPayment->tourPackage->name }}</h5>
                                            @if($tourPayment->tourPackage->subtitle)
                                            <p class="text-theme">{{ $tourPayment->tourPackage->subtitle }}</p>
                                            @endif
                                            <p class="box-text">{{ $tourPayment->tourPackage->description }}</p>
                                            @if($tourPayment->tourPackage->duration)
                                            <p><strong>Duration:</strong> {{ $tourPayment->tourPackage->duration }}</p>
                                            @endif
                                            <p><strong>Difficulty:</strong>
                                                <span
                                                    class="ms-1 p-1 text-white bg-{{ $tourPayment->tourPackage->difficulty_badge }}">
                                                    {{ ucfirst($tourPayment->tourPackage->difficulty_level) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($tourPayment->payment_status == 'pending')
                        <div class="row mt-40">
                            <div class="col-12 text-center">
                                <div class="alert alert-warning">
                                    <h5>Complete Your Payment</h5>
                                    <p>Your booking is confirmed but payment is still pending. Please complete your
                                        payment to secure your tour.</p>
                                </div>
                                <form action="{{ route('tour-booking.payment', $tourPayment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="th-btn">
                                        Complete Payment
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                        <div class="row mt-40">
                            <div class="col-12 text-center">
                                <a href="/packages" class="th-btn style4 me-3">Browse More Tours</a>
                                <a href="/" class="th-btn">Back to Home</a>
                            </div>
                        </div>

                        <div class="contact-info-card mt-40">
                            <h4 class="box-title mb-20 text-center">Need Help?</h4>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="contact-item">
                                        <i class="fas fa-phone text-theme mb-10" style="font-size: 1.5rem;"></i>
                                        <p><strong>Call Us</strong><br>+94 76 779 9721</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="contact-item">
                                        <i class="fas fa-envelope text-theme mb-10" style="font-size: 1.5rem;"></i>
                                        <p><strong>Email Us</strong><br>info@kingscastle.lk</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt text-theme mb-10"
                                            style="font-size: 1.5rem;"></i>
                                        <p><strong>Visit Us</strong><br>Nuwara Eliya, Sri Lanka</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .booking-confirmation-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }

    .detail-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .booking-info-list {
        list-style: none;
        padding: 0;
    }

    .booking-info-list li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .booking-info-list li:last-child {
        border-bottom: none;
    }

    .contact-info-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 30px;
        border: 2px dashed #ddd;
    }

    .contact-item {
        padding: 15px;
    }

    @media (max-width: 768px) {
        .booking-confirmation-card {
            padding: 20px;
        }

        .detail-card {
            padding: 15px;
        }
    }
</style>
@endpush

@endsection