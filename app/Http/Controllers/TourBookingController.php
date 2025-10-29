<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourBooking;
use App\Models\TourPayment;
use App\Models\TourPackage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\TourBookingConfirmation;
use App\Mail\TourPaymentConfirmation;
use App\Mail\TourBookingStatusUpdate;
use App\Mail\AdminTourBookingNotification;

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

            $tourBookingN = TourBooking::with(['tourPackage', 'tourPayment'])->findOrFail($tourBooking->id);

            // Send confirmation email to guest
            Mail::to($tourBookingN->guest_email)->send(new TourBookingConfirmation($tourBookingN));

            // Send notification email to admin
            Mail::to('reservation@kingcastle.com')->send(new AdminTourBookingNotification($tourBookingN));

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

        Mail::to($tourBooking->guest_email)->send(new TourBookingStatusUpdate($tourBooking, $tourBooking->status));

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
     * Send tour booking confirmation email manually (Admin)
     */
    public function sendTourBookingConfirmation($id)
    {
        try {
            $tourBooking = TourBooking::with(['tourPackage', 'tourPayment'])->findOrFail($id);

            Mail::to($tourBooking->guest_email)->send(new TourBookingConfirmation($tourBooking));

            Log::info('Manual tour booking confirmation email sent', [
                'tour_booking_id' => $tourBooking->id,
                'email' => $tourBooking->guest_email,
                'sent_by' => Auth::user()->name ?? 'Admin'
            ]);

            return back()->with('success', 'Tour booking confirmation email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send manual tour booking confirmation email', [
                'tour_booking_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    /**
     * Send tour payment confirmation email manually (Admin)
     */
    public function sendTourPaymentConfirmation($id)
    {
        try {
            $tourBooking = TourBooking::with(['tourPackage', 'tourPayment'])->findOrFail($id);

            if (!$tourBooking->tourPayment || $tourBooking->tourPayment->payment_status !== 'paid') {
                return back()->with('error', 'Payment must be completed before sending payment confirmation.');
            }

            Mail::to($tourBooking->guest_email)->send(new TourPaymentConfirmation($tourBooking));

            Log::info('Manual tour payment confirmation email sent', [
                'tour_booking_id' => $tourBooking->id,
                'email' => $tourBooking->guest_email,
                'sent_by' => Auth::user()->name ?? 'Admin'
            ]);

            return back()->with('success', 'Tour payment confirmation email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send manual tour payment confirmation email', [
                'tour_booking_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    /**
     * Send tour status update email manually (Admin)
     */
    public function sendTourStatusUpdate($id)
    {
        try {
            $tourBooking = TourBooking::with(['tourPackage', 'tourPayment'])->findOrFail($id);

            Mail::to($tourBooking->guest_email)->send(new TourBookingStatusUpdate($tourBooking, $tourBooking->status));

            Log::info('Manual tour status update email sent', [
                'tour_booking_id' => $tourBooking->id,
                'email' => $tourBooking->guest_email,
                'status' => $tourBooking->status,
                'sent_by' => Auth::user()->name ?? 'Admin'
            ]);

            return back()->with('success', 'Tour status update email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send manual tour status update email', [
                'tour_booking_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to send email. Please try again.');
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


    /**
     * Handle tour payment notification
     */
    public function handlePaymentNotify(Request $request)
    {
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
            $tourPayment = \App\Models\TourPayment::with(['tourBooking.tourPackage'])->find($request->order_id);

            if ($tourPayment) {
                $tourPayment->update([
                    'payment_status' => 'paid',
                    'payment_details' => [
                        'payment_id' => $request->payment_id,
                        'payhere_amount' => $request->payhere_amount,
                        'payhere_currency' => $request->payhere_currency,
                        'card_holder_name' => $request->card_holder_name ?? null,
                        'card_no' => $request->card_no ?? null,
                    ]
                ]);

                // Update booking status
                if ($tourPayment->tourBooking) {
                    $tourPayment->tourBooking->update(['status' => 'confirmed']);
                }

                $tourBooking = $tourPayment->tourBooking;

                Mail::to($tourBooking->guest_email)->send(new TourPaymentConfirmation($tourBooking));
            }

            return response('Payment successful', 200);
        } else {
            // Payment failed or invalid
            $tourPayment = \App\Models\TourPayment::find($request->order_id);

            if ($tourPayment) {
                $tourPayment->update(['payment_status' => 'failed']);
            }

            return response('Payment verification failed', 400);
        }
    }

    /**
     * Handle tour payment return
     */
    public function handlePaymentReturn(Request $request)
    {
        $tourPackages = TourPackage::paginate(10);
        $tourPayment = \App\Models\TourPayment::with('tourBooking')->find($request->order_id);
        return view('public-site.packages', compact('tourPackages'))->with('booking', $tourPayment->tourBooking ?? null);
    }

    /**
     * Handle tour payment cancel
     */
    public function handlePaymentCancel(Request $request)
    {
        $tourPackages = TourPackage::paginate(10);
        $tourPayment = \App\Models\TourPayment::with('tourBooking')->find($request->order_id);
        return view('public-site.packages', compact('tourPackages'))->with('booking', $tourPayment->tourBooking ?? null);
    }
}
