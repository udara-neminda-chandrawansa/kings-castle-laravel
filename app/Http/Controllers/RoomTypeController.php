<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::withCount('bookings')->paginate(10);
        return view('admin-dashboard.room-types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-dashboard.room-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types,name',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:100',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Process amenities
            $amenities = $validated['amenities'] ?? [];
            $amenities = array_filter($amenities, function($amenity) {
                return !empty(trim($amenity));
            });

            // Handle image upload
            $imagePath = 'assets/img/drive-images-2-webp/kc1.webp'; // Default image
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/rooms'), $imageName);
                $imagePath = 'upload/rooms/' . $imageName;
            }

            $roomType = RoomType::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price_per_night' => $validated['price_per_night'],
                'max_occupancy' => $validated['max_occupancy'],
                'amenities' => $amenities,
                'image_path' => $imagePath,
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return redirect()->route('room-types.index')
                           ->with('success', 'Room type created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Failed to create room type. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
    {
        $roomType->load('bookings');
        return view('admin-dashboard.room-types.show', compact('roomType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $roomType)
    {
        return view('admin-dashboard.room-types.edit', compact('roomType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types,name,' . $roomType->id,
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:100',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Process amenities
            $amenities = $validated['amenities'] ?? [];
            $amenities = array_filter($amenities, function($amenity) {
                return !empty(trim($amenity));
            });

            // Handle image upload
            $imagePath = $roomType->image_path; // Keep existing image by default
            if ($request->hasFile('image_file')) {
                // Delete old image if it's in upload directory
                if ($roomType->image_path && str_starts_with($roomType->image_path, 'upload/rooms/')) {
                    $oldImagePath = public_path($roomType->image_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Upload new image
                $image = $request->file('image_file');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/rooms'), $imageName);
                $imagePath = 'upload/rooms/' . $imageName;
            }

            $roomType->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price_per_night' => $validated['price_per_night'],
                'max_occupancy' => $validated['max_occupancy'],
                'amenities' => $amenities,
                'image_path' => $imagePath,
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return redirect()->route('room-types.index')
                           ->with('success', 'Room type updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Failed to update room type. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        try {
            // Check if room type has bookings
            if ($roomType->bookings()->count() > 0) {
                return back()->with('error', 'Cannot delete room type with existing bookings. Set it as inactive instead.');
            }

            // Delete uploaded image if it exists
            if ($roomType->image_path && str_starts_with($roomType->image_path, 'upload/rooms/')) {
                $imagePath = public_path($roomType->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $roomType->delete();
            return redirect()->route('room-types.index')
                           ->with('success', 'Room type deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete room type. Please try again.');
        }
    }

    /**
     * Toggle room type status
     */
    public function toggleStatus(RoomType $roomType)
    {
        $roomType->update(['is_active' => !$roomType->is_active]);
        
        $status = $roomType->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Room type {$status} successfully!");
    }
}
