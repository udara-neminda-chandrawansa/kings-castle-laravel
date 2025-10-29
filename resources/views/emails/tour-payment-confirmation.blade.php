<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tour Payment Confirmation</title>
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
            background: #e8f5e9;
            margin: 10px -20px -20px -20px;
            padding: 15px 20px;
        }
        .tour-details {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #e9ecef;
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
            .receipt-item {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Payment Confirmed!</h1>
            <p>Tour Payment Successfully Processed</p>
        </div>

        <div class="content">
            <h2>Dear {{ $tourBooking->guest_name }},</h2>
            <p>Great news! Your payment for the tour booking has been successfully processed. Your tour is now fully confirmed.</p>

            <div class="payment-info">
                <h3>Payment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Payment Reference</span>
                        <span class="info-value">{{ $tourBooking->tourPayment->payment_reference ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Status</span>
                        <span class="status-badge">{{ ucfirst($tourBooking->tourPayment->payment_status) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Date</span>
                        <span class="info-value">{{ $tourBooking->tourPayment->updated_at->format('M d, Y H:i A') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Method</span>
                        <span class="info-value">{{ ucfirst($tourBooking->tourPayment->payment_method ?? 'Online Payment') }}</span>
                    </div>
                </div>
            </div>

            <div class="receipt-section">
                <div class="receipt-header">
                    <h3 style="margin: 0;">Payment Receipt</h3>
                    <small>Booking Reference: {{ $tourBooking->booking_reference }}</small>
                </div>

                @if($tourBooking->tourPackage)
                <div class="tour-details">
                    <strong>{{ $tourBooking->tourPackage->name }}</strong>
                    <br>
                    <small class="text-muted">{{ $tourBooking->tourPackage->description ?? 'Tour Package' }}</small>
                </div>

                <div class="receipt-item">
                    <span>Tour Package ({{ $tourBooking->participants }} {{ $tourBooking->participants == 1 ? 'person' : 'people' }})</span>
                    <span>${{ number_format($tourBooking->tourPackage->price * $tourBooking->participants, 2) }}</span>
                </div>
                @endif

                <div class="receipt-item">
                    <span><strong>Total Amount Paid</strong></span>
                    <span><strong>${{ number_format($tourBooking->tourPayment->total_amount, 2) }}</strong></span>
                </div>
            </div>

            <div class="payment-info">
                <h3>Tour Booking Details</h3>
                <div class="info-grid">
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
                        <span class="info-label">Contact Number</span>
                        <span class="info-value">{{ $tourBooking->guest_phone }}</span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #e8f5e8; border-radius: 8px;">
                <h4 style="color: #155724; margin-top: 0;">Your Tour is Confirmed!</h4>
                <p>Your payment has been successfully processed and your tour is now fully confirmed. Here are the important details for your tour:</p>

                <p><strong>Meeting Point:</strong> Hotel Lobby<br>
                <strong>Departure Time:</strong> 8:00 AM (Please arrive 15 minutes early)<br>
                <strong>Tour Date:</strong> {{ $tourBooking->tour_date->format('l, F j, Y') }}</p>

                <p><strong>Important Reminders:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Bring comfortable walking shoes</li>
                    <li>Don't forget your sun hat and sunglasses</li>
                    <li>Carry a water bottle to stay hydrated</li>
                    <li>Bring your camera for memorable moments</li>
                </ul>

                <p>A confirmation email with all tour details has been sent separately. If you need to make any changes or have questions, please contact us immediately.</p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Kings Castle Hotel!</p>
            <p>
                <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> |
                <a href="tel:+94767799721">+94 777 611 290</a>
            </p>
            <p>No:30, Gemunu Pura, Magasthota, Nuwara Eliya, Sri Lanka</p>
            <p>&copy; {{ date('Y') }} Kings Castle Hotel. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
