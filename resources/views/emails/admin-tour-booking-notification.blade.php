@extends('emails.layout')

@section('title', 'New Tour Booking Notification')

@section('header')
    <div class="header">
        <h1>Kings Castle Hotel</h1>
        <p>New Tour Booking Alert</p>
    </div>
@endsection

@section('content')
    <div class="alert alert-info">
        <strong>📅 New Tour Booking Received!</strong>
        <br>
        A new tour booking has been made on your website. Please review the details below.
    </div>

    <h2>Booking Details</h2>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;">
        <h3 style="color: #28a745; margin-top: 0;">Tour Information</h3>
        
        <p><strong>Booking Reference:</strong> {{ $tourBooking->booking_reference }}</p>
        <p><strong>Tour Package:</strong> {{ $tourBooking->tourPackage->name ?? 'N/A' }}</p>
        <p><strong>Tour Date:</strong> {{ $tourBooking->tour_date->format('l, F j, Y') }}</p>
        <p><strong>Participants:</strong> {{ $tourBooking->participants }} {{ $tourBooking->participants == 1 ? 'person' : 'people' }}</p>
        <p><strong>Status:</strong> <span style="background: #ffc107; color: #000; padding: 3px 8px; border-radius: 4px; font-size: 12px; text-transform: uppercase;">{{ ucfirst($tourBooking->status) }}</span></p>
        
        @if($tourBooking->tourPayment)
        <p><strong>Total Amount:</strong> ${{ number_format($tourBooking->tourPayment->total_amount, 2) }}</p>
        <p><strong>Payment Status:</strong> <span style="background: #ffc107; color: #000; padding: 3px 8px; border-radius: 4px; font-size: 12px; text-transform: uppercase;">{{ ucfirst($tourBooking->tourPayment->payment_status) }}</span></p>
        @endif
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #17a2b8;">
        <h3 style="color: #17a2b8; margin-top: 0;">Guest Information</h3>
        
        <p><strong>Name:</strong> {{ $tourBooking->guest_name }}</p>
        <p><strong>Email:</strong> <a href="mailto:{{ $tourBooking->guest_email }}">{{ $tourBooking->guest_email }}</a></p>
        <p><strong>Phone:</strong> <a href="tel:{{ $tourBooking->guest_phone }}">{{ $tourBooking->guest_phone }}</a></p>
        <p><strong>Address:</strong> {{ $tourBooking->guest_address }}</p>
        @if($tourBooking->guest_address_2)
        <p><strong>Address 2:</strong> {{ $tourBooking->guest_address_2 }}</p>
        @endif
    </div>

    @if($tourBooking->tourPackage)
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6f42c1;">
        <h3 style="color: #6f42c1; margin-top: 0;">Package Details</h3>
        
        <p><strong>Package Name:</strong> {{ $tourBooking->tourPackage->name }}</p>
        @if($tourBooking->tourPackage->subtitle)
        <p><strong>Subtitle:</strong> {{ $tourBooking->tourPackage->subtitle }}</p>
        @endif
        <p><strong>Price per Person:</strong> ${{ number_format($tourBooking->tourPackage->price, 2) }}</p>
        @if($tourBooking->tourPackage->duration)
        <p><strong>Duration:</strong> {{ $tourBooking->tourPackage->duration }}</p>
        @endif
        @if($tourBooking->tourPackage->difficulty_level)
        <p><strong>Difficulty Level:</strong> {{ ucfirst($tourBooking->tourPackage->difficulty_level) }}</p>
        @endif
    </div>
    @endif

    @if($tourBooking->special_requests)
    <div style="background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;">
        <h3 style="color: #856404; margin-top: 0;">Special Requests</h3>
        <p>{{ $tourBooking->special_requests }}</p>
    </div>
    @endif

    <div class="alert alert-success">
        <strong>📋 Next Steps:</strong>
        <br>
        • Review the booking details in your admin dashboard
        <br>
        • Confirm the tour booking and process payment if needed
        <br>
        • Contact the guest if you have any questions
        <br>
        • Prepare for the scheduled tour date
    </div>

    <p style="text-align: center; margin-top: 30px;">
        <a href="{{ route('dashboard') }}" class="btn" style="background: #28a745;">View in Admin Dashboard</a>
    </p>

    <p style="font-size: 14px; color: #6c757d; margin-top: 30px;">
        <strong>Booking submitted at:</strong> {{ $tourBooking->created_at->format('F j, Y \a\t g:i A') }}
    </p>
@endsection
