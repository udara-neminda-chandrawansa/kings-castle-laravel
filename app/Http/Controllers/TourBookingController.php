<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourBooking;
use App\Models\TourPayment;
use App\Models\TourPackage;
use Illuminate\Support\Facades\DB;

class TourBookingController extends Controller
{
    /**
     * Store tour booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_address' => 'required|string',
            'guest_address_2' => 'nullable|string',
            'tour_date' => 'required|date|after_or_equal:today',
            'participants' => 'required|integer|min:1',
            'special_requests' => 'nullable|string'
        ]);

        $tourPackage = TourPackage::findOrFail($validated['tour_package_id']);

        // Validate participant count
        if ($validated['participants'] < $tourPackage->min_participants) {
            return back()->withInput()
                         ->withErrors(['participants' => 'Minimum ' . $tourPackage->min_participants . ' participants required.']);
        }

        if ($tourPackage->max_participants && $validated['participants'] > $tourPackage->max_participants) {
            return back()->withInput()
                         ->withErrors(['participants' => 'Maximum ' . $tourPackage->max_participants . ' participants allowed.']);
        }

        // Calculate total amount
        $totalAmount = $tourPackage->price ? ($tourPackage->price * $validated['participants']) : 0;

        try {
            DB::beginTransaction();

            // Create the booking
            $tourBooking = TourBooking::create([
                'booking_reference' => TourBooking::generateBookingReference(),
                'tour_package_id' => $validated['tour_package_id'],
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'guest_address' => $validated['guest_address'],
                'guest_address_2' => $validated['guest_address_2'],
                'participants' => $validated['participants'],
                'tour_date' => $validated['tour_date'],
                'special_requests' => $validated['special_requests'],
                'status' => 'pending'
            ]);

            // Create the payment record
            $tourPayment = TourPayment::create([
                'tour_booking_id' => $tourBooking->id,
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'payment_reference' => TourPayment::generatePaymentReference()
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tour booking created successfully!',
                    'booking_id' => $tourBooking->id,
                    'payment_id' => $tourPayment->id
                ]);
            }

            return redirect()->route('tour-booking.show', $tourBooking->id)
                           ->with('success', 'Tour booking created successfully!');

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
     * Show tour booking confirmation
     */
    public function show(TourBooking $tourBooking)
    {
        $tourBooking->load(['tourPackage', 'tourPayment']);
        return view('public-site.tour-booking-confirmation', compact('tourBooking'));
    }

    /**
     * Process tour payment
     */
    public function processPayment($id)
    {
        $tourBooking = TourBooking::with(['tourPackage', 'tourPayment'])->findOrFail($id);
        
        if (!$tourBooking->tourPackage->is_active) {
            return back()->with('error', 'This tour package is no longer available.');
        }

        $tourPayment = $tourBooking->tourPayment;
        $fullTotal = $tourPayment->total_amount;

        // Initialize payment gateway
        $merchant_id = env('PAYHERE_MERCHANT_ID');
        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');

        $paymentData = [
            "merchant_id" => $merchant_id,
            "return_url" => route('tour-payment.return'),
            "cancel_url" => route('tour-payment.cancel'),
            "notify_url" => route('tour-payment.notify'),
            "order_id" => $tourPayment->id,
            "items" => "Tour: " . $tourBooking->tourPackage->name,
            "currency" => "LKR",
            "amount" => number_format((float) $fullTotal, 2, '.', ''),
            "first_name" => $tourBooking->guest_name,
            "last_name" => "",
            "email" => $tourBooking->guest_email,
            "phone" => $tourBooking->guest_phone,
            "address" => $tourBooking->guest_address,
            "city" => "Nuwara Eliya",
            "country" => "Sri Lanka",
        ];

        // Generate the hash signature
        $paymentData['hash'] = strtoupper(md5(
            $merchant_id . $paymentData['order_id'] . $paymentData['amount'] . $paymentData['currency'] . strtoupper(md5($merchant_secret))
        ));

        // Update booking and payment status
        $tourBooking->update(['status' => 'confirmed']);

        return view('public-site.payhere-redirect', compact('paymentData'));
    }

    /**
     * Get tour booking details for admin view (AJAX)
     */
    public function getDetails($id)
    {
        try {
            $tourBooking = TourBooking::with(['tourPackage', 'tourPayment'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $tourBooking->id,
                    'booking_reference' => $tourBooking->booking_reference,
                    'guest_name' => $tourBooking->guest_name,
                    'guest_email' => $tourBooking->guest_email,
                    'guest_phone' => $tourBooking->guest_phone,
                    'guest_address' => $tourBooking->guest_address,
                    'guest_address_2' => $tourBooking->guest_address_2,
                    'participants' => $tourBooking->participants,
                    'tour_date' => $tourBooking->tour_date->format('Y-m-d'),
                    'special_requests' => $tourBooking->special_requests,
                    'status' => $tourBooking->status,
                    'created_at' => $tourBooking->created_at->toISOString(),
                    'tour_package' => [
                        'id' => $tourBooking->tourPackage->id,
                        'name' => $tourBooking->tourPackage->name,
                        'subtitle' => $tourBooking->tourPackage->subtitle,
                        'description' => $tourBooking->tourPackage->description,
                        'price' => $tourBooking->tourPackage->price,
                        'duration' => $tourBooking->tourPackage->duration,
                        'difficulty_level' => $tourBooking->tourPackage->difficulty_level,
                        'image_path' => $tourBooking->tourPackage->image_path ? asset($tourBooking->tourPackage->image_path) : null,
                    ],
                    'tour_payment' => $tourBooking->tourPayment ? [
                        'id' => $tourBooking->tourPayment->id,
                        'payment_reference' => $tourBooking->tourPayment->payment_reference,
                        'total_amount' => $tourBooking->tourPayment->total_amount,
                        'payment_status' => $tourBooking->tourPayment->payment_status,
                        'payment_details' => $tourBooking->tourPayment->payment_details,
                        'created_at' => $tourBooking->tourPayment->created_at->toISOString(),
                    ] : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tour booking not found.'
            ], 404);
        }
    }

    /**
     * Delete a tour booking (Admin)
     */
    public function destroy($id)
    {
        try {
            $tourBooking = TourBooking::findOrFail($id);
            $tourBooking->delete(); // This will cascade delete the payment too

            return redirect()->route('dashboard')
                           ->with('success', 'Tour booking deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                           ->with('error', 'Failed to delete tour booking.');
        }
    }
}
