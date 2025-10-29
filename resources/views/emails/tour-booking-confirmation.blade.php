<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tour Booking Confirmation</title>
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
        .content {
            padding: 30px;
        }
        .booking-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .booking-info h3 {
            color: #28a745;
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
        .tour-section {
            margin: 20px 0;
        }
        .tour-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tour-name {
            font-weight: bold;
            color: #333;
        }
        .tour-price {
            color: #28a745;
            font-weight: bold;
        }
        .total-section {
            background: #28a745;
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
        }
        .status-pending {
            background: #ffc107;
            color: #000;
        }
        .status-confirmed {
            background: #28a745;
            color: white;
        }
        .status-cancelled {
            background: #dc3545;
            color: white;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .tour-item {
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
            <p>Tour Booking Confirmation</p>
        </div>

        <div class="content">
            <h2>Dear {{ $tourBooking->guest_name }},</h2>
            <p>Thank you for choosing Kings Castle Hotel for your tour experience! We're delighted to confirm your tour booking.</p>

            <div class="booking-info">
                <h3>Booking Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Booking Reference</span>
                        <span class="info-value">{{ $tourBooking->booking_reference }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="status-badge status-{{ $tourBooking->status }}">{{ ucfirst($tourBooking->status) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tour Date</span>
                        <span class="info-value">{{ $tourBooking->tour_date->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Participants</span>
                        <span class="info-value">{{ $tourBooking->participants }} {{ $tourBooking->participants == 1 ? 'Person' : 'People' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Guest Name</span>
                        <span class="info-value">{{ $tourBooking->guest_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Contact</span>
                        <span class="info-value">{{ $tourBooking->guest_phone }}</span>
                    </div>
                </div>
            </div>

            @if($tourBooking->tourPackage)
            <div class="tour-section">
                <h3>Selected Tour Package</h3>
                <div class="tour-item">
                    <div>
                        <div class="tour-name">{{ $tourBooking->tourPackage->name }}</div>
                        <small class="text-muted">{{ $tourBooking->tourPackage->description ?? 'Exciting tour experience' }}</small>
                    </div>
                    <div class="tour-price">${{ number_format($tourBooking->tourPackage->price, 2) }}/person</div>
                </div>
            </div>
            @endif

            @if($tourBooking->tourPayment)
            <div class="total-section">
                <h3 style="margin-top: 0; font-size: 18px;">Total Amount</h3>
                <p class="total-amount">${{ number_format($tourBooking->tourPayment->total_amount, 2) }}</p>
                <small>Payment Status: {{ ucfirst($tourBooking->tourPayment->payment_status) }}</small>
            </div>
            @endif

            @if($tourBooking->special_requests)
            <div class="booking-info">
                <h3>Special Requests</h3>
                <p>{{ $tourBooking->special_requests }}</p>
            </div>
            @endif

            <div style="margin-top: 30px; padding: 20px; background: #e8f5e8; border-radius: 8px;">
                <h4 style="color: #155724; margin-top: 0;">What's Next?</h4>
                @if($tourBooking->status === 'pending')
                <p>Your tour booking is currently pending confirmation. We'll send you another email once your booking is confirmed and payment is processed.</p>
                @else
                <p>Your tour booking is confirmed! We look forward to providing you with an amazing tour experience.</p>
                @endif

                <p><strong>Meeting Point:</strong> Hotel Lobby<br>
                <strong>Departure Time:</strong> 8:00 AM (Please arrive 15 minutes early)</p>

                <p><strong>What to Bring:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Comfortable walking shoes</li>
                    <li>Sun hat and sunglasses</li>
                    <li>Water bottle</li>
                    <li>Camera for memorable moments</li>
                </ul>

                <p>If you have any questions or need to make changes to your tour booking, please contact us at <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> or call us at +94 777 611 290.</p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Kings Castle Hotel. All rights reserved.</p>
            <p>
                <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> |
                <a href="tel:+94767799721">+94 777 611 290</a>
            </p>
            <p>No:30, Gemunu Pura, Magasthota, Nuwara Eliya, Sri Lanka</p>
        </div>
    </div>
</body>
</html>
