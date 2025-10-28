<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use Illuminate\Support\Facades\DB;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourPackages = TourPackage::paginate(10);
        return view('admin-dashboard.tour-packages.index', compact('tourPackages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-dashboard.tour-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'required|string|max:20',
            'duration' => 'nullable|string|max:100',
            'includes' => 'nullable|array',
            'includes.*' => 'string|max:200',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,moderate,challenging',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Process includes
            $includes = $validated['includes'] ?? [];
            $includes = array_filter($includes, function($include) {
                return !empty(trim($include));
            });

            // Handle image upload
            $imagePath = 'assets/img/tours/helicopter1.jpg'; // Default image
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/tours'), $imageName);
                $imagePath = 'upload/tours/' . $imageName;
            }

            $tourPackage = TourPackage::create([
                'name' => $validated['name'],
                'subtitle' => $validated['subtitle'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'price_unit' => $validated['price_unit'],
                'duration' => $validated['duration'],
                'includes' => $includes,
                'image_path' => $imagePath,
                'notes' => $validated['notes'],
                'difficulty_level' => $validated['difficulty_level'],
                'min_participants' => $validated['min_participants'],
                'max_participants' => $validated['max_participants'],
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return redirect()->route('tour-packages.index')
                           ->with('success', 'Tour package created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Failed to create tour package. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourPackage $tourPackage)
    {
        return view('admin-dashboard.tour-packages.show', compact('tourPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourPackage $tourPackage)
    {
        return view('admin-dashboard.tour-packages.edit', compact('tourPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'required|string|max:20',
            'duration' => 'nullable|string|max:100',
            'includes' => 'nullable|array',
            'includes.*' => 'string|max:200',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,moderate,challenging',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Process includes
            $includes = $validated['includes'] ?? [];
            $includes = array_filter($includes, function($include) {
                return !empty(trim($include));
            });

            // Handle image upload
            $imagePath = $tourPackage->image_path; // Keep existing image by default
            if ($request->hasFile('image_file')) {
                // Delete old image if it's in upload directory
                if ($tourPackage->image_path && str_starts_with($tourPackage->image_path, 'upload/tours/')) {
                    $oldImagePath = public_path($tourPackage->image_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Upload new image
                $image = $request->file('image_file');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/tours'), $imageName);
                $imagePath = 'upload/tours/' . $imageName;
            }

            $tourPackage->update([
                'name' => $validated['name'],
                'subtitle' => $validated['subtitle'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'price_unit' => $validated['price_unit'],
                'duration' => $validated['duration'],
                'includes' => $includes,
                'image_path' => $imagePath,
                'notes' => $validated['notes'],
                'difficulty_level' => $validated['difficulty_level'],
                'min_participants' => $validated['min_participants'],
                'max_participants' => $validated['max_participants'],
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return redirect()->route('tour-packages.index')
                           ->with('success', 'Tour package updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Failed to update tour package. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourPackage $tourPackage)
    {
        try {
            $tourPackage->delete();
            return redirect()->route('tour-packages.index')
                           ->with('success', 'Tour package deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete tour package. Please try again.');
        }
    }

    /**
     * Toggle tour package status
     */
    public function toggleStatus(TourPackage $tourPackage)
    {
        $tourPackage->update(['is_active' => !$tourPackage->is_active]);
        
        $status = $tourPackage->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Tour package {$status} successfully!");
    }

    /**
     * Show single tour package for booking
     */
    public function viewPackage(TourPackage $tourPackage)
    {
        return view('public-site.view-package', compact('tourPackage'));
    }

    /**
     * Store tour booking
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_address' => 'required|string',
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

            $tourPayment = \App\Models\TourPayment::create([
                'tour_package_id' => $validated['tour_package_id'],
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'guest_address' => $validated['guest_address'],
                'participants' => $validated['participants'],
                'tour_date' => $validated['tour_date'],
                'special_requests' => $validated['special_requests'],
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'status' => 'pending'
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tour booking created successfully!',
                    'booking_id' => $tourPayment->id
                ]);
            }

            return redirect()->route('tour-booking.show', $tourPayment->id)
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
    public function showBooking(\App\Models\TourPayment $tourPayment)
    {
        $tourPayment->load('tourPackage');
        return view('public-site.tour-booking-confirmation', compact('tourPayment'));
    }

    /**
     * Process tour payment
     */
    public function processPayment($id)
    {
        $tourPayment = \App\Models\TourPayment::with('tourPackage')->findOrFail($id);
        
        if (!$tourPayment->tourPackage->is_active) {
            return back()->with('error', 'This tour package is no longer available.');
        }

        $fullTotal = $tourPayment->total_amount;

        // Initialize payment gateway
        $merchant_id = env('PAYHERE_MERCHANT_ID');
        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');

        $paymentData = [
            "merchant_id" => $merchant_id,
            "return_url" => route('tour-payment.return'),
            "cancel_url" => route('tour-payment.cancel'),
            "notify_url" => route('tour-payment.notify'),
            "order_id" => $id,
            "items" => "Tour: " . $tourPayment->tourPackage->name,
            "currency" => "LKR",
            "amount" => number_format((float) $fullTotal, 2, '.', ''),
            "first_name" => $tourPayment->guest_name,
            "last_name" => "",
            "email" => $tourPayment->guest_email,
            "phone" => $tourPayment->guest_phone,
            "address" => $tourPayment->guest_address,
            "city" => "Nuwara Eliya",
            "country" => "Sri Lanka",
        ];

        // Generate the hash signature
        $paymentData['hash'] = strtoupper(md5(
            $merchant_id . $paymentData['order_id'] . $paymentData['amount'] . $paymentData['currency'] . strtoupper(md5($merchant_secret))
        ));

        // Update payment record
        $tourPayment->update([
            'payment_reference' => \App\Models\TourPayment::generatePaymentReference(),
            'status' => 'confirmed'
        ]);

        return view('public-site.payhere-redirect', compact('paymentData'));
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
            $tourPayment = \App\Models\TourPayment::with('tourPackage')->find($request->order_id);
            
            if ($tourPayment) {
                $tourPayment->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'payment_details' => [
                        'payment_id' => $request->payment_id,
                        'payhere_amount' => $request->payhere_amount,
                        'payhere_currency' => $request->payhere_currency,
                        'card_holder_name' => $request->card_holder_name ?? null,
                        'card_no' => $request->card_no ?? null,
                    ]
                ]);
            }

            return response('Payment successful', 200);
        } else {
            // Payment failed or invalid
            $tourPayment = \App\Models\TourPayment::find($request->order_id);
            
            if ($tourPayment) {
                $tourPayment->update([
                    'payment_status' => 'failed'
                ]);
            }
            
            return response('Payment verification failed', 400);
        }
    }

    /**
     * Handle tour payment return
     */
    public function handlePaymentReturn(Request $request)
    {
        $tourPayment = \App\Models\TourPayment::find($request->order_id);
        return view('public-site.packages')->with('booking', $tourPayment);
    }

    /**
     * Handle tour payment cancel
     */
    public function handlePaymentCancel(Request $request)
    {
        $tourPayment = \App\Models\TourPayment::find($request->order_id);
        return view('public-site.packages')->with('booking', $tourPayment);
    }

    /**
     * Delete a tour booking (Admin)
     */
    public function destroyBooking($id)
    {
        try {
            $tourPayment = \App\Models\TourPayment::findOrFail($id);
            $tourPayment->delete();

            return redirect()->route('dashboard')
                           ->with('success', 'Tour booking deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                           ->with('error', 'Failed to delete tour booking.');
        }
    }
}
