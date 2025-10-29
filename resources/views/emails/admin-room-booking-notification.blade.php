@extends('emails.layout')

@section('title', 'New Room Booking Notification')

@section('header')
    <div class="header">
        <h1>Kings Castle Hotel</h1>
        <p>New Room Booking Alert</p>
    </div>
@endsection

@section('content')
    <div class="alert alert-info">
        <strong>🏨 New Room Booking Received!</strong>
        <br>
        A new room booking has been made on your website. Please review the details below.
    </div>

    <h2>Booking Details</h2>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #667eea;">
        <h3 style="color: #667eea; margin-top: 0;">Reservation Information</h3>
        
        <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
        <p><strong>Check-in Date:</strong> {{ $booking->check_in_date->format('l, F j, Y') }}</p>
        <p><strong>Check-out Date:</strong> {{ $booking->check_out_date->format('l, F j, Y') }}</p>
        <p><strong>Duration:</strong> {{ $booking->nights }} {{ $booking->nights == 1 ? 'night' : 'nights' }}</p>
        <p><strong>Guests:</strong> {{ $booking->adults }} {{ $booking->adults == 1 ? 'adult' : 'adults' }}{{ $booking->children > 0 ? ', ' . $booking->children . ' ' . ($booking->children == 1 ? 'child' : 'children') : '' }}</p>
        <p><strong>Status:</strong> <span style="background: #ffc107; color: #000; padding: 3px 8px; border-radius: 4px; font-size: 12px; text-transform: uppercase;">{{ ucfirst($booking->status) }}</span></p>
        
        @if($booking->payment)
        <p><strong>Total Amount:</strong> Rs {{ number_format($booking->payment->total_amount, 2) }}</p>
        <p><strong>Payment Status:</strong> <span style="background: #ffc107; color: #000; padding: 3px 8px; border-radius: 4px; font-size: 12px; text-transform: uppercase;">{{ ucfirst($booking->payment->payment_status) }}</span></p>
        @endif
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #17a2b8;">
        <h3 style="color: #17a2b8; margin-top: 0;">Guest Information</h3>
        
        <p><strong>Name:</strong> {{ $booking->guest_name }}</p>
        <p><strong>Email:</strong> <a href="mailto:{{ $booking->guest_email }}">{{ $booking->guest_email }}</a></p>
        <p><strong>Phone:</strong> <a href="tel:{{ $booking->guest_phone }}">{{ $booking->guest_phone }}</a></p>
        <p><strong>Address:</strong> {{ $booking->guest_address }}</p>
        @if($booking->guest_address_2)
        <p><strong>Address 2:</strong> {{ $booking->guest_address_2 }}</p>
        @endif
    </div>

    @if($booking->roomTypes && $booking->roomTypes->count() > 0)
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;">
        <h3 style="color: #28a745; margin-top: 0;">Selected Rooms</h3>
        
        @foreach($booking->roomTypes as $roomType)
        <div style="background: white; padding: 15px; margin: 10px 0; border-radius: 6px; border: 1px solid #e9ecef;">
            <p style="margin: 0;"><strong>{{ $roomType->name }}</strong></p>
            <p style="margin: 5px 0; color: #6c757d; font-size: 14px;">{{ $roomType->description ?? 'Luxurious accommodation' }}</p>
            <p style="margin: 0; color: #28a745; font-weight: bold;">Rs {{ number_format($roomType->price_per_night, 2) }}/night</p>
            <p style="margin: 5px 0; font-size: 14px;">Max Occupancy: {{ $roomType->max_occupancy }} guests</p>
        </div>
        @endforeach
    </div>
    @endif

    @if($booking->special_requests)
    <div style="background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;">
        <h3 style="color: #856404; margin-top: 0;">Special Requests</h3>
        <p>{{ $booking->special_requests }}</p>
    </div>
    @endif

    <div class="alert alert-success">
        <strong>📋 Next Steps:</strong>
        <br>
        • Review the booking details in your admin dashboard
        <br>
        • Confirm room availability for the requested dates
        <br>
        • Process the booking confirmation and payment if needed
        <br>
        • Contact the guest if you have any questions
    </div>

    <p style="text-align: center; margin-top: 30px;">
        <a href="{{ route('dashboard') }}" class="btn" style="background: #667eea;">View in Admin Dashboard</a>
    </p>

    <p style="font-size: 14px; color: #6c757d; margin-top: 30px;">
        <strong>Booking submitted at:</strong> {{ $booking->created_at->format('F j, Y \a\t g:i A') }}
    </p>
@endsection
