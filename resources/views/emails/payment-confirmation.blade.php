<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Confirmation</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .payment-info {
            background: #d4edda;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .payment-info h3 {
            color: #155724;
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
        .receipt-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .receipt-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .receipt-item:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #28a745;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #28a745;
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
        .room-calculation {
            text-align: right;
            color: #666;
            font-size: 14px;
        }
        .footer {
            background: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #28a745;
            text-decoration: none;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
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
            .receipt-item {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✓</div>
            <h1>Payment Confirmed!</h1>
            <p>Kings Castle Hotel</p>
        </div>

        <div class="content">
            <h2>Dear {{ $booking->guest_name }},</h2>
            <p>Great news! Your payment has been successfully processed and your booking is now <strong>confirmed</strong>.</p>

            <div class="payment-info">
                <h3>Payment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Payment Status</span>
                        <span class="status-badge">{{ ucfirst($booking->payment->payment_status) }}</span>
                    </div>
                    @if($booking->payment->payment_reference)
                    <div class="info-item">
                        <span class="info-label">Payment Reference</span>
                        <span class="info-value">{{ $booking->payment->payment_reference }}</span>
                    </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">Booking Reference</span>
                        <span class="info-value">{{ $booking->booking_reference }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Date</span>
                        <span class="info-value">{{ $booking->payment->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="receipt-section">
                <div class="receipt-header">
                    <h3 style="margin: 0; color: #333;">Payment Receipt</h3>
                    <p style="margin: 5px 0 0 0; color: #666;">Booking Period: {{ $booking->check_in_date->format('M d') }} - {{ $booking->check_out_date->format('M d, Y') }}</p>
                </div>

                @foreach($booking->roomTypes as $roomType)
                <div class="room-item">
                    <div>
                        <div class="room-name">{{ $roomType->name }}</div>
                        <small class="text-muted">{{ $booking->nights }} {{ $booking->nights == 1 ? 'night' : 'nights' }}</small>
                    </div>
                    <div class="room-calculation">
                        <div>Rs {{ number_format($roomType->price_per_night, 2) }}/night</div>
                        <div style="color: #333; font-weight: bold;">Rs {{ number_format($roomType->price_per_night * $booking->nights, 2) }}</div>
                    </div>
                </div>
                @endforeach

                <div class="receipt-item">
                    <span>Total Amount Paid</span>
                    <span>Rs {{ number_format($booking->payment->total_amount, 2) }}</span>
                </div>
            </div>

            <div style="background: #e8f5e8; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745;">
                <h4 style="color: #155724; margin-top: 0;">Your Stay Details</h4>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Check-in</span>
                        <span class="info-value">{{ $booking->check_in_date->format('l, M d, Y') }}</span>
                        <small>After 2:00 PM</small>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check-out</span>
                        <span class="info-value">{{ $booking->check_out_date->format('l, M d, Y') }}</span>
                        <small>Before 12:00 PM</small>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Guests</span>
                        <span class="info-value">{{ $booking->adults }} Adults{{ $booking->children > 0 ? ', ' . $booking->children . ' Children' : '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Duration</span>
                        <span class="info-value">{{ $booking->nights }} {{ $booking->nights == 1 ? 'Night' : 'Nights' }}</span>
                    </div>
                </div>
            </div>

            @if($booking->special_requests)
            <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <h4 style="margin-top: 0;">Special Requests</h4>
                <p style="margin-bottom: 0;">{{ $booking->special_requests }}</p>
            </div>
            @endif

            <div style="margin-top: 30px; text-align: center; padding: 20px; background: #f1f3f4; border-radius: 8px;">
                <h4 style="color: #333; margin-top: 0;">We're Excited to Welcome You!</h4>
                <p>Your booking is confirmed and we're preparing everything for your arrival. If you have any questions or need assistance, please don't hesitate to contact us.</p>
                <p style="margin-bottom: 0;"><strong>Contact:</strong> <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> | <a href="tel:+94777611290">+94 777 611 290</a></p>
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
