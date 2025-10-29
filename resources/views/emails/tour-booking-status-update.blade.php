<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tour Booking Status Update</title>
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
        .header-completed {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
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
        .status-completed {
            background: #d1ecf1;
            border-left-color: #17a2b8;
            color: #0c5460;
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
        .tour-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
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
        .status-badge.confirmed {
            background: #28a745;
            color: white;
        }
        .status-badge.cancelled {
            background: #dc3545;
            color: white;
        }
        .status-badge.completed {
            background: #17a2b8;
            color: white;
        }
        .status-badge.pending {
            background: #ffc107;
            color: #000;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header header-{{ $tourBooking->status }}">
            <div class="status-icon">
                @if($tourBooking->status === 'confirmed')
                    ✅
                @elseif($tourBooking->status === 'cancelled')
                    ❌
                @elseif($tourBooking->status === 'completed')
                    🎉
                @else
                    ⏳
                @endif
            </div>
            <h1>Tour Status Updated</h1>
            <p>Your booking status has been changed to: {{ ucfirst($tourBooking->status) }}</p>
        </div>

        <div class="content">
            <h2>Dear {{ $tourBooking->guest_name }},</h2>

            @if($tourBooking->status === 'confirmed')
                <p>Great news! Your tour booking has been confirmed. We're excited to provide you with an amazing tour experience.</p>
            @elseif($tourBooking->status === 'cancelled')
                <p>We regret to inform you that your tour booking has been cancelled. If this was unexpected, please contact us immediately for assistance.</p>
            @elseif($tourBooking->status === 'completed')
                <p>Thank you for joining us on the tour! We hope you had a wonderful experience. We'd love to hear your feedback about the tour.</p>
            @else
                <p>This is to update you about the current status of your tour booking.</p>
            @endif

            <div class="status-info status-{{ $tourBooking->status }}">
                <h3>Current Status: <span class="status-badge {{ $tourBooking->status }}">{{ ucfirst($tourBooking->status) }}</span></h3>

                @if($tourBooking->status === 'confirmed')
                    <p><strong>Your tour is now confirmed!</strong> Please make sure to arrive at the meeting point on time.</p>
                @elseif($tourBooking->status === 'cancelled')
                    <p><strong>Booking Cancelled:</strong> If you have any questions about this cancellation or need assistance with rebooking, please contact our support team.</p>
                @elseif($tourBooking->status === 'completed')
                    <p><strong>Tour Completed:</strong> We hope you enjoyed your experience with us. Thank you for choosing Kings Castle Hotel for your tour needs.</p>
                @else
                    <p><strong>Status Update:</strong> Your booking status has been updated. Please check the details below.</p>
                @endif
            </div>

            <div class="tour-details">
                <h3>Tour Booking Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Booking Reference</span>
                        <span class="info-value">{{ $tourBooking->booking_reference }}</span>
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
                        <span class="info-label">Contact</span>
                        <span class="info-value">{{ $tourBooking->guest_phone }}</span>
                    </div>
                </div>

                @if($tourBooking->tourPackage)
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                    <strong>{{ $tourBooking->tourPackage->name }}</strong>
                    <br>
                    <small class="text-muted">{{ $tourBooking->tourPackage->description ?? 'Tour Package' }}</small>
                    <br>
                    <strong style="color: #28a745;">${{ number_format($tourBooking->tourPackage->price, 2) }}/person</strong>
                </div>
                @endif
            </div>

            @if($tourBooking->tourPayment)
            <div class="tour-details">
                <h3>Payment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Total Amount</span>
                        <span class="info-value">${{ number_format($tourBooking->tourPayment->total_amount, 2) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Status</span>
                        <span class="info-value">{{ ucfirst($tourBooking->tourPayment->payment_status) }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div style="margin-top: 30px; padding: 20px; background: {{ $tourBooking->status === 'confirmed' ? '#e8f5e8' : ($tourBooking->status === 'cancelled' ? '#f8e8e8' : '#e8f4f8') }}; border-radius: 8px;">
                @if($tourBooking->status === 'confirmed')
                    <h4 style="color: #155724; margin-top: 0;">Important Information</h4>
                    <p><strong>Meeting Point:</strong> Hotel Lobby<br>
                    <strong>Departure Time:</strong> 8:00 AM (Please arrive 15 minutes early)</p>

                    <p><strong>What to Bring:</strong></p>
                    <ul style="margin: 10px 0; padding-left: 20px;">
                        <li>Comfortable walking shoes</li>
                        <li>Sun hat and sunglasses</li>
                        <li>Water bottle</li>
                        <li>Camera for memorable moments</li>
                    </ul>
                @elseif($tourBooking->status === 'cancelled')
                    <h4 style="color: #721c24; margin-top: 0;">Need Help?</h4>
                    <p>If you need assistance with rebooking or have questions about the cancellation, our team is here to help.</p>
                @elseif($tourBooking->status === 'completed')
                    <h4 style="color: #0c5460; margin-top: 0;">Thank You!</h4>
                    <p>We hope you enjoyed your tour experience. Your feedback helps us improve our services.</p>
                @else
                    <h4 style="margin-top: 0;">Need Assistance?</h4>
                    <p>If you have any questions about this status update, please don't hesitate to contact us.</p>
                @endif

                <p>For any questions or assistance, please contact us at <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a> or call us at +94 777 611 290.</p>
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
