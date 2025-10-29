<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Status Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header-confirmed {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .header-cancelled {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        }
        .header-checked-in {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        }
        .header-checked-out {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
        .header-pending {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .status-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .status-info {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid;
        }
        .status-confirmed {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            border-left-color: #dc3545;
            color: #721c24;
        }
        .status-checked-in {
            background: #d1ecf1;
            border-left-color: #17a2b8;
            color: #0c5460;
        }
        .status-checked-out {
            background: #d6d8db;
            border-left-color: #6c757d;
            color: #383d41;
        }
        .status-pending {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
        }
        .status-info h3 {
            margin-top: 0;
            font-size: 18px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 15px 0;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
            font-size: 16px;
        }
        .booking-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .room-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .room-name {
            font-weight: bold;
            color: #333;
        }
        .footer {
            background: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #17a2b8;
            text-decoration: none;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-confirmed {
            background: #28a745;
            color: white;
        }
        .badge-cancelled {
            background: #dc3545;
            color: white;
        }
        .badge-checked-in {
            background: #17a2b8;
            color: white;
        }
        .badge-checked-out {
            background: #6c757d;
            color: white;
        }
        .badge-pending {
            background: #ffc107;
            color: #000;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .room-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header header-{{ $status }}">
            @if($status === 'confirmed')
                <div class="status-icon">✓</div>
                <h1>Booking Confirmed!</h1>
            @elseif($status === 'cancelled')
                <div class="status-icon">✗</div>
                <h1>Booking Cancelled</h1>
            @elseif($status === 'checked-in')
                <div class="status-icon">🏨</div>
                <h1>Welcome to Kings Castle!</h1>
            @elseif($status === 'checked-out')
                <div class="status-icon">👋</div>
                <h1>Thank You for Staying!</h1>
            @else
                <div class="status-icon">⏳</div>
                <h1>Status Update</h1>
            @endif
            <p>Kings Castle Hotel</p>
        </div>

        <div class="content">
            <h2>Dear {{ $booking->guest_name }},</h2>

            @if($status === 'confirmed')
                <p>Excellent news! Your booking has been confirmed. We're thrilled to welcome you to Kings Castle Hotel.</p>
            @elseif($status === 'cancelled')
                <p>We're sorry to inform you that your booking has been cancelled. If you have any questions, please contact us immediately.</p>
            @elseif($status === 'checked-in')
                <p>Welcome to Kings Castle Hotel! We hope you have a wonderful stay with us.</p>
            @elseif($status === 'checked-out')
                <p>Thank you for choosing Kings Castle Hotel. We hope you had a pleasant stay and look forward to welcoming you again soon.</p>
            @else
                <p>We wanted to update you on the status of your booking.</p>
            @endif

            <div class="status-info status-{{ $status }}">
                <h3>Booking Status Update</h3>
                <p>Your booking status has been updated to: <span class="status-badge badge-{{ $status }}">{{ ucfirst($status) }}</span></p>
                <p><strong>Updated on:</strong> {{ now()->format('l, M d, Y \a\t H:i') }}</p>
            </div>

            <div class="booking-summary">
                <h3>Booking Summary</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Booking Reference</span>
                        <span class="info-value">{{ $booking->booking_reference }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check-in Date</span>
                        <span class="info-value">{{ $booking->check_in_date->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check-out Date</span>
                        <span class="info-value">{{ $booking->check_out_date->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Guests</span>
                        <span class="info-value">{{ $booking->adults }} Adults{{ $booking->children > 0 ? ', ' . $booking->children . ' Children' : '' }}</span>
                    </div>
                </div>

                <h4>Room{{ count($booking->roomTypes) > 1 ? 's' : '' }}</h4>
                @foreach($booking->roomTypes as $roomType)
                <div class="room-item">
                    <div class="room-name">{{ $roomType->name }}</div>
                    <div>Rs {{ number_format($roomType->price_per_night, 2) }}/night</div>
                </div>
                @endforeach

                @if($booking->payment)
                <div style="text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                    <strong>Total Amount: Rs {{ number_format($booking->payment->total_amount, 2) }}</strong>
                </div>
                @endif
            </div>

            @if($status === 'confirmed')
                <div style="background: #e8f5e8; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <h4 style="color: #155724; margin-top: 0;">What's Next?</h4>
                    <ul style="color: #155724; margin-bottom: 0;">
                        <li>Your booking is now confirmed and guaranteed</li>
                        <li>Check-in starts at 2:00 PM on {{ $booking->check_in_date->format('M d, Y') }}</li>
                        <li>You'll receive check-in instructions closer to your arrival date</li>
                        <li>Contact us anytime if you need to modify your booking</li>
                    </ul>
                </div>
            @elseif($status === 'cancelled')
                <div style="background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <h4 style="color: #721c24; margin-top: 0;">Cancellation Information</h4>
                    <p style="color: #721c24; margin-bottom: 0;">If you have any questions about this cancellation or need assistance with a new booking, please contact our customer service team immediately.</p>
                </div>
            @elseif($status === 'checked-in')
                <div style="background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <h4 style="color: #0c5460; margin-top: 0;">Enjoy Your Stay!</h4>
                    <ul style="color: #0c5460; margin-bottom: 0;">
                        <li>Wi-Fi: Free throughout the hotel</li>
                        <li>Breakfast: 7:00 AM - 10:00 AM</li>
                        <li>Concierge: Available 24/7 for assistance</li>
                        <li>Check-out: Before 12:00 PM on {{ $booking->check_out_date->format('M d, Y') }}</li>
                    </ul>
                </div>
            @elseif($status === 'checked-out')
                <div style="background: #d6d8db; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <h4 style="color: #383d41; margin-top: 0;">We Hope You Enjoyed Your Stay!</h4>
                    <p style="color: #383d41;">We'd love to hear about your experience. Please consider leaving us a review and don't hesitate to book with us again for your future visits to the area.</p>
                </div>
            @endif

            <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f1f3f4; border-radius: 8px;">
                <p>If you have any questions or concerns, please don't hesitate to contact us:</p>
                <p><strong>Email:</strong> <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a><br>
                <strong>Phone:</strong> <a href="tel:+94777611290">+94 777 611 290</a></p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Kings Castle Hotel. All rights reserved.</p>
            <p>
                <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> |
                <a href="tel:+94777611290">+94 777 611 290</a>
            </p>
            <p>No:30, Gemunu Pura, Magasthota, Nuwara Eliya, Sri Lanka</p>
        </div>
    </div>
</body>
</html>
