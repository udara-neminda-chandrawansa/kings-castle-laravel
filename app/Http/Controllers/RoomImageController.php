<?php

namespace App\Http\Controllers;

use App\Models\RoomImage;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class RoomImageController extends Controller
{
    /**
     * Display a listing of images for a specific room type.
     */
    public function index(RoomType $roomType)
    {
        $roomType->load('roomImages');
        return view('admin-dashboard.room-images.index', compact('roomType'));
    }

    /**
     * Store multiple newly created images in storage.
     */
    public function store(Request $request, RoomType $roomType)
    {
        $request->validate([
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'alt_texts' => 'nullable|array',
            'alt_texts.*' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $uploadedImages = [];
            $nextSortOrder = RoomImage::where('room_type_id', $roomType->id)->max('sort_order') + 1;

            foreach ($request->file('images') as $index => $image) {
                // Generate unique filename
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload/room-gallery'), $imageName);
                $imagePath = 'upload/room-gallery/' . $imageName;

                // Get alt text for this image
                $altText = $request->alt_texts[$index] ?? $roomType->name . ' - Gallery Image';

                $roomImage = RoomImage::create([
                    'room_type_id' => $roomType->id,
                    'image_path' => $imagePath,
                    'alt_text' => $altText,
                    'sort_order' => $nextSortOrder++
                ]);

                $uploadedImages[] = $roomImage;
            }

            DB::commit();

            //if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => count($uploadedImages) . ' image(s) uploaded successfully!',
                    'images' => $uploadedImages
                ]);
            //}

            //return redirect()->route('room-images.index', $roomType)->with('success', count($uploadedImages) . ' image(s) uploaded successfully!');

        } catch (ValidationException $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Room image upload error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload images: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                         ->with('error', 'Failed to upload images. Please try again.');
        }
    }

    /**
     * Update the specified image.
     */
    public function update(Request $request, RoomType $roomType, RoomImage $roomImage)
    {
        try {
            $request->validate([
                'alt_text' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            // Ensure the image belongs to the specified room type
            if ($roomImage->room_type_id != $roomType->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image does not belong to this room type.'
                ], 400);
            }

            $roomImage->update([
                'alt_text' => $request->alt_text,
                'sort_order' => $request->sort_order ?? $roomImage->sort_order
            ]);

            //if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Image updated successfully!',
                    'image' => $roomImage
                ]);
            //}

            //return back()->with('success', 'Image updated successfully!');

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Room image update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the image.'
            ], 500);
        }
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroy(RoomType $roomType, RoomImage $roomImage)
    {
        try {
            // Ensure the image belongs to the specified room type
            if ($roomImage->room_type_id != $roomType->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image does not belong to this room type.'
                ], 400);
            }

            // Delete physical file
            if ($roomImage->image_path && str_starts_with($roomImage->image_path, 'upload/room-gallery/')) {
                $imagePath = public_path($roomImage->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $roomImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Room image delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image. Please try again.'
            ], 500);
        }
    }

    /**
     * Update sort orders for multiple images
     */
    public function updateSortOrder(Request $request, RoomType $roomType)
    {
        $request->validate([
            'image_orders' => 'required|array',
            'image_orders.*' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->image_orders as $imageId => $sortOrder) {
                RoomImage::where('id', $imageId)
                        ->where('room_type_id', $roomType->id)
                        ->update(['sort_order' => $sortOrder]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order. Please try again.'
            ], 500);
        }
    }
}
