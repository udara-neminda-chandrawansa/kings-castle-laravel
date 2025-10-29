<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
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
        .content {
            padding: 30px;
        }
        .booking-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .booking-info h3 {
            color: #667eea;
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
        .rooms-section {
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
        .room-price {
            color: #667eea;
            font-weight: bold;
        }
        .total-section {
            background: #667eea;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            border-radius: 8px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .footer {
            background: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
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
        .status-pending {
            background: #ffc107;
            color: #000;
        }
        .status-confirmed {
            background: #28a745;
            color: white;
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
        <div class="header">
            <h1>Kings Castle Hotel</h1>
            <p>Booking Confirmation</p>
        </div>

        <div class="content">
            <h2>Dear {{ $booking->guest_name }},</h2>
            <p>Thank you for choosing Kings Castle Hotel! We're delighted to confirm your booking.</p>

            <div class="booking-info">
                <h3>Booking Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Booking Reference</span>
                        <span class="info-value">{{ $booking->booking_reference }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
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
                        <span class="info-label">Duration</span>
                        <span class="info-value">{{ $booking->nights }} {{ $booking->nights == 1 ? 'Night' : 'Nights' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Guests</span>
                        <span class="info-value">{{ $booking->adults }} Adults{{ $booking->children > 0 ? ', ' . $booking->children . ' Children' : '' }}</span>
                    </div>
                </div>
            </div>

            <div class="rooms-section">
                <h3>Selected Rooms</h3>
                @foreach($booking->roomTypes as $roomType)
                <div class="room-item">
                    <div>
                        <div class="room-name">{{ $roomType->name }}</div>
                        <small class="text-muted">{{ $roomType->description ?? 'Luxurious accommodation' }}</small>
                    </div>
                    <div class="room-price">Rs {{ number_format($roomType->price_per_night, 2) }}/night</div>
                </div>
                @endforeach
            </div>

            @if($booking->payment)
            <div class="total-section">
                <h3 style="margin-top: 0; font-size: 18px;">Total Amount</h3>
                <p class="total-amount">Rs {{ number_format($booking->payment->total_amount, 2) }}</p>
                <small>Payment Status: {{ ucfirst($booking->payment->payment_status) }}</small>
            </div>
            @endif

            @if($booking->special_requests)
            <div class="booking-info">
                <h3>Special Requests</h3>
                <p>{{ $booking->special_requests }}</p>
            </div>
            @endif

            <div style="margin-top: 30px; padding: 20px; background: #e8f4f8; border-radius: 8px;">
                <h4 style="color: #0c5460; margin-top: 0;">What's Next?</h4>
                @if($booking->status === 'pending')
                <p>Your booking is currently pending confirmation. We'll send you another email once your booking is confirmed and payment is processed.</p>
                @else
                <p>Your booking is confirmed! We look forward to welcoming you to Kings Castle Hotel.</p>
                @endif

                <p><strong>Check-in:</strong> 2:00 PM<br>
                <strong>Check-out:</strong> 12:00 PM</p>

                <p>If you have any questions or need to make changes to your booking, please contact us at <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> or call us at +94 777 611 290.</p>
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
