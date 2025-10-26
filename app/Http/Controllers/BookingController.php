<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource (Admin Dashboard).
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'roomType'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('admin-dashboard.bookings', compact('bookings'));
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

        $availableRooms = RoomType::where('is_active', true)
                                 ->where('max_occupancy', '>=', $request->adults)
                                 ->get();

        return response()->json([
            'available_rooms' => $availableRooms,
            'nights' => $nights,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string'
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkOut->diffInDays($checkIn);
        $totalAmount = $roomType->price_per_night * $nights;

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'booking_reference' => Booking::generateBookingReference(),
                'user_id' => Auth::id(),
                'room_type_id' => $validated['room_type_id'],
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'adults' => $validated['adults'],
                'children' => $validated['children'] ?? 0,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'nights' => $nights,
                'total_amount' => $totalAmount,
                'special_requests' => $validated['special_requests'],
                'status' => 'pending'
            ]);

            DB::commit();

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
        $booking->load(['user', 'roomType']);
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

        $booking->update($validated);

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
    public function processPayment(Request $request, Booking $booking)
    {
        // This is where PayHere integration will go
        // For now, we'll just mark as paid for testing

        $booking->update([
            'payment_status' => 'paid',
            'payment_reference' => 'PH' . time(),
            'status' => 'confirmed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully!'
        ]);
    }
}
