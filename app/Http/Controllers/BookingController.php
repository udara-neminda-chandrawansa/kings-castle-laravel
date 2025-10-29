<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Payment;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Mail\PaymentConfirmation;
use App\Mail\BookingStatusUpdate;
use App\Mail\AdminRoomBookingNotification;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource (Admin Dashboard).
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'roomTypes', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tourBookings = \App\Models\TourBooking::with(['tourPackage', 'tourPayment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate tour booking stats
        $allTourBookings = \App\Models\TourBooking::with('tourPayment')->get();
        $tourStats = [
            'total' => $allTourBookings->count(),
            'pending' => $allTourBookings->where('status', 'pending')->count(),
            'confirmed' => $allTourBookings->where('status', 'confirmed')->count(),
            'revenue' => $allTourBookings->filter(function($booking) {
                return $booking->tourPayment && $booking->tourPayment->payment_status === 'paid';
            })->sum(function($booking) {
                return $booking->tourPayment->total_amount;
            })
        ];

        return view('admin-dashboard.bookings', compact('bookings', 'tourBookings', 'tourStats'));
    }

    /**
     * Check availability for booking form
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0'
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkOut->diffInDays($checkIn);

        // Get active room types meeting occupancy
        $suitableRoomTypes = RoomType::where('is_active', true)
            ->where('max_occupancy', '>=', $request->adults)
            ->get();

        // Get booked room types during that period
        $bookedRoomTypeIds = BookingRoom::whereHas('booking', function ($query) use ($checkIn, $checkOut) {
            $query->where('check_in_date', '<', $checkOut)
                ->where('check_out_date', '>', $checkIn)
                ->whereIn('status', ['confirmed', 'checked_in', 'pending']);
        })
            ->pluck('room_type_id')
            ->unique()
            ->toArray();

        // Remove booked ones
        $availableRooms = $suitableRoomTypes->reject(
            fn($roomType) =>
            in_array($roomType->id, $bookedRoomTypeIds)
        );

        return response()->json([
            'available_rooms' => $availableRooms->values(),
            'nights' => $nights,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'total_rooms_found' => $suitableRoomTypes->count(),
            'booked_rooms_count' => count($bookedRoomTypeIds)
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create1(Request $request)
    {
        // Get available room types based on guest count if provided
        $adults = $request->get('adults', 1);
        $children = $request->get('children', 0);

        $roomTypesQuery = RoomType::where('is_active', true);

        // Filter by occupancy if adults parameter is provided
        if ($request->has('adults')) {
            $roomTypesQuery->where('max_occupancy', '>=', $adults);
        }

        $roomTypes = $roomTypesQuery->get();

        // If coming from availability check
        $selectedRoom = null;
        if ($request->has('room_type_id')) {
            $selectedRoom = RoomType::find($request->room_type_id);
        }

        // Pass booking parameters to view
        $bookingData = [
            'check_in' => $request->get('check_in', date('Y-m-d')),
            'check_out' => $request->get('check_out', date('Y-m-d', strtotime('+1 day'))),
            'adults' => $adults,
            'children' => $children
        ];

        return view('public-site.booking-form', compact('roomTypes', 'selectedRoom', 'bookingData'));
    }

    public function create(Request $request)
    {
        $adults = $request->get('adults', 1);
        $children = $request->get('children', 0);
        $checkIn = $request->get('check_in');
        $checkOut = $request->get('check_out');

        $roomTypesQuery = RoomType::where('is_active', true)
            ->where('max_occupancy', '>=', $adults);

        // If check-in/out are provided, filter unavailable rooms
        if ($checkIn && $checkOut) {
            $checkInDate = Carbon::parse($checkIn);
            $checkOutDate = Carbon::parse($checkOut);

            // Find booked room types in that date range
            $bookedRoomTypeIds = BookingRoom::whereHas('booking', function ($query) use ($checkInDate, $checkOutDate) {
                $query->where('check_in_date', '<', $checkOutDate)
                    ->where('check_out_date', '>', $checkInDate)
                    ->whereIn('status', ['confirmed', 'checked_in', 'pending']);
            })
                ->pluck('room_type_id')
                ->unique()
                ->toArray();

            // Exclude those booked ones
            $roomTypesQuery->whereNotIn('id', $bookedRoomTypeIds);
        }

        $roomTypes = $roomTypesQuery->get();

        // If coming from availability check
        $selectedRoom = null;
        if ($request->has('room_type_id')) {
            $selectedRoom = RoomType::find($request->room_type_id);
        }

        // Pass booking parameters to view
        $bookingData = [
            'check_in' => $checkIn ?? date('Y-m-d'),
            'check_out' => $checkOut ?? date('Y-m-d', strtotime('+1 day')),
            'adults' => $adults,
            'children' => $children
        ];

        return view('public-site.booking-form', compact('roomTypes', 'selectedRoom', 'bookingData'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_ids' => 'required|array|min:1',
            'room_type_ids.*' => 'required|exists:room_types,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_address' => 'required|string|max:255',
            'guest_address_2' => 'nullable|string|max:255',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string'
        ]);

        $roomTypes = RoomType::whereIn('id', $validated['room_type_ids'])->get();
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkOut->diffInDays($checkIn);

        // Calculate total amount for all selected rooms
        $totalAmount = $roomTypes->sum('price_per_night') * $nights;

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'booking_reference' => Booking::generateBookingReference(),
                'user_id' => Auth::id(),
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'guest_address' => $validated['guest_address'],
                'guest_address_2' => $validated['guest_address_2'] ?? null,
                'adults' => $validated['adults'],
                'children' => $validated['children'] ?? 0,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'nights' => $nights,
                'special_requests' => $validated['special_requests'],
                'status' => 'pending'
            ]);

            // Create booking room relationships
            foreach ($validated['room_type_ids'] as $roomTypeId) {
                BookingRoom::create([
                    'booking_id' => $booking->id,
                    'room_type_id' => $roomTypeId
                ]);
            }

            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'payment_reference' => null,
                'payment_details' => null
            ]);

            DB::commit();

            // Send booking confirmation email
            try {
                // Load relationships for email
                $booking->load(['roomTypes', 'payment']);

                // Send confirmation email to guest
                Mail::to($booking->guest_email)->send(new BookingConfirmation($booking));
                Log::info('Booking confirmation email sent', ['booking_id' => $booking->id, 'email' => $booking->guest_email]);

                // Send notification email to admin
                Mail::to('reservation@kingcastle.com')->send(new AdminRoomBookingNotification($booking));
                Log::info('Admin room booking notification sent', ['booking_id' => $booking->id, 'admin_email' => 'reservation@kingcastle.com']);

            } catch (\Exception $emailException) {
                Log::error('Failed to send booking confirmation email', [
                    'booking_id' => $booking->id,
                    'email' => $booking->guest_email,
                    'error' => $emailException->getMessage()
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'booking' => $booking,
                    'message' => 'Booking created successfully!'
                ]);
            }

            return redirect()->route('booking.show', $booking->id)
                ->with('success', 'Booking created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create booking. Please try again.'
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to create booking. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'roomTypes', 'payment']);
        return view('public-site.booking-confirmation', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource (Admin only).
     */
    public function edit(Booking $booking)
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('admin-dashboard.booking-edit', compact('booking', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage (Admin only).
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'special_requests' => 'nullable|string'
        ]);

        // Store original status to check if it changed
        $originalStatus = $booking->status;
        $originalPaymentStatus = $booking->payment ? $booking->payment->payment_status : null;

        // Update booking status and special requests
        $booking->update([
            'status' => $validated['status'],
            'special_requests' => $validated['special_requests']
        ]);

        // Update payment status if payment exists
        if ($booking->payment) {
            $booking->payment->update([
                'payment_status' => $validated['payment_status']
            ]);
        }

        // Send email notifications for status changes
        try {
            // Load relationships for email
            $booking->load(['roomTypes', 'payment']);

            // Send status update email if status changed
            if ($originalStatus !== $validated['status']) {
                Mail::to($booking->guest_email)->send(new BookingStatusUpdate($booking, $validated['status']));
                Log::info('Booking status update email sent', [
                    'booking_id' => $booking->id,
                    'email' => $booking->guest_email,
                    'old_status' => $originalStatus,
                    'new_status' => $validated['status']
                ]);
            }

            // Send payment confirmation email if payment status changed to paid
            if ($originalPaymentStatus !== 'paid' && $validated['payment_status'] === 'paid') {
                Mail::to($booking->guest_email)->send(new PaymentConfirmation($booking));
                Log::info('Payment confirmation email sent via status update', [
                    'booking_id' => $booking->id,
                    'email' => $booking->guest_email
                ]);
            }

        } catch (\Exception $emailException) {
            Log::error('Failed to send status update email', [
                'booking_id' => $booking->id,
                'email' => $booking->guest_email,
                'error' => $emailException->getMessage()
            ]);
        }

        return back()->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage (Admin only).
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking deleted successfully!');
    }

    /**
     * Process payment (PayHere integration placeholder)
     */
    public function processPayment($id)
    {
        $booking = Booking::with('payment')->findOrFail($id);
        $payment = $booking->payment;

        if (!$payment) {
            return back()->with('error', 'Payment record not found for this booking.');
        }

        $fullTotal = $payment->total_amount;

        // Initialize payment gateway
        $merchant_id = env('PAYHERE_MERCHANT_ID');
        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');

        $paymentData = [
            "merchant_id" => $merchant_id,
            "return_url" => route('payment.return'), // Route for handling return URL
            "cancel_url" => route('payment.cancel'), // Route for handling cancel URL
            "notify_url" => route('payment.api.notify'), // Route for handling notify URL
            "order_id" => $id,
            "items" => "KC Booking",
            "currency" => "LKR",
            "amount" => number_format((float) $fullTotal, 2, '.', ''),
            "first_name" => $booking->guest_name,
            "last_name" => $booking->guest_name,
            "email" => $booking->guest_email,
            "phone" => $booking->guest_phone,
            "address" => $booking->guest_address ?? 'N/A',
            "city" => $booking->guest_address_2 ?? 'N/A',
            "country" => "Sri Lanka",
        ];

        // Generate the hash signature
        $paymentData['hash'] = strtoupper(md5(
            $merchant_id . $paymentData['order_id'] . $paymentData['amount'] . $paymentData['currency'] . strtoupper(md5($merchant_secret))
        ));

        // Update payment record
        $payment->update([
            'payment_status' => 'pending',
            'payment_reference' => Payment::generatePaymentReference()
        ]);

        // Update booking status
        $booking->update(['status' => 'confirmed']);

        Mail::to($booking->guest_email)->send(new BookingStatusUpdate($booking, $booking->status));

        return view('public-site.payhere-redirect', compact('paymentData'));

        // Return JSON response with payment data
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Payment initialized successfully',
        //     'paymentData' => $paymentData,
        // ]);
    }

    public function handleNotify(Request $request)
    {
        // Verify the payment

        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');
        $generatedHash = strtoupper(md5(
            $request->merchant_id .
                $request->order_id .
                $request->payhere_amount .
                $request->payhere_currency .
                $request->status_code .
                strtoupper(md5($merchant_secret))
        ));

        if ($generatedHash == $request->md5sig && $request->status_code == 2) {
            // Payment is successful
            $booking = Booking::with(['payment', 'roomTypes'])->find($request->order_id);

            if ($booking && $booking->payment) {
                $booking->payment->update([
                    'payment_status' => 'paid',
                    'payment_details' => [
                        'payhere_amount' => $request->payhere_amount,
                        'payhere_currency' => $request->payhere_currency,
                        'status_code' => $request->status_code,
                        'md5sig' => $request->md5sig,
                        'payment_id' => $request->payment_id ?? null,
                        'processed_at' => now()
                    ]
                ]);

                // Update booking status to confirmed
                $booking->update(['status' => 'confirmed']);

                // Send payment confirmation email
                try {
                    Mail::to($booking->guest_email)->send(new PaymentConfirmation($booking));
                    Log::info('Payment confirmation email sent', ['booking_id' => $booking->id, 'email' => $booking->guest_email]);
                } catch (\Exception $emailException) {
                    Log::error('Failed to send payment confirmation email', [
                        'booking_id' => $booking->id,
                        'email' => $booking->guest_email,
                        'error' => $emailException->getMessage()
                    ]);
                }
            }

            // Send email to customer
            // $customer = $payment->customer;
            // $orderDetails = $payment->orders->map(function ($order) {
            //     return [
            //         'product_name' => $order->product->name,
            //         'quantity' => $order->qty,
            //         'price' => $order->product->discounted_price,
            //     ];
            // });

            // Mail::to($customer->email)->send(new OrderConfirmation($orderDetails, $customer, $payment->total));

            return response('Payment successful', 200);
        } else {
            // Payment failed or invalid
            $booking = Booking::with('payment')->find($request->order_id);

            if ($booking && $booking->payment) {
                $booking->payment->update([
                    'payment_status' => 'failed',
                    'payment_details' => [
                        'error_code' => $request->status_code ?? null,
                        'error_message' => 'Payment verification failed',
                        'failed_at' => now()
                    ]
                ]);
            }

            return response('Payment verification failed', 400);
        }
    }

    public function handleReturn(Request $request)
    {
        //  dd($request->order_id);

        $roomTypes = RoomType::where('is_active', true)->get();

        $booking = Booking::find($request->order_id);
        return view('public-site.services', compact('booking', 'roomTypes'));
    }

    public function handleCancel(Request $request)
    {

        $booking = Booking::find($request->order_id);
        return view('public-site.services', compact('booking'));
    }

    /**
     * Send booking confirmation email manually (Admin)
     */
    public function sendBookingConfirmation($id)
    {
        try {
            $booking = Booking::with(['roomTypes', 'payment'])->findOrFail($id);

            Mail::to($booking->guest_email)->send(new BookingConfirmation($booking));

            Log::info('Manual booking confirmation email sent', [
                'booking_id' => $booking->id,
                'email' => $booking->guest_email,
                'sent_by' => Auth::user()->name ?? 'Admin'
            ]);

            return back()->with('success', 'Booking confirmation email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send manual booking confirmation email', [
                'booking_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    /**
     * Send payment confirmation email manually (Admin)
     */
    public function sendPaymentConfirmation($id)
    {
        try {
            $booking = Booking::with(['roomTypes', 'payment'])->findOrFail($id);

            if (!$booking->payment || $booking->payment->payment_status !== 'paid') {
                return back()->with('error', 'Payment must be completed before sending payment confirmation.');
            }

            Mail::to($booking->guest_email)->send(new PaymentConfirmation($booking));

            Log::info('Manual payment confirmation email sent', [
                'booking_id' => $booking->id,
                'email' => $booking->guest_email,
                'sent_by' => Auth::user()->name ?? 'Admin'
            ]);

            return back()->with('success', 'Payment confirmation email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send manual payment confirmation email', [
                'booking_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    /**
     * Send status update email manually (Admin)
     */
    public function sendStatusUpdate($id)
    {
        try {
            $booking = Booking::with(['roomTypes', 'payment'])->findOrFail($id);

            Mail::to($booking->guest_email)->send(new BookingStatusUpdate($booking, $booking->status));

            Log::info('Manual status update email sent', [
                'booking_id' => $booking->id,
                'email' => $booking->guest_email,
                'status' => $booking->status,
                'sent_by' => Auth::user()->name ?? 'Admin'
            ]);

            return back()->with('success', 'Status update email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send manual status update email', [
                'booking_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }
}
