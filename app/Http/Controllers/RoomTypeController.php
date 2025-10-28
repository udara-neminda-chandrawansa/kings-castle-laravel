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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp,tiff|max:51200', // 50MB max (will be compressed)
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
                // Generate unique filename - prefer WebP but fallback to JPG
                $webpSupported = function_exists('imagewebp');
                $extension = $webpSupported ? '.webp' : '.jpg';
                $imageName = time() . '_' . uniqid() . $extension;
                $fullImagePath = public_path('upload/rooms/' . $imageName);
                
                // Ensure directory exists
                if (!file_exists(public_path('upload/rooms'))) {
                    mkdir(public_path('upload/rooms'), 0755, true);
                }
                
                // Convert and compress image
                $actualOutputPath = $this->convertToWebP($request->file('image_file'), $fullImagePath);
                
                // Update imagePath with actual saved file path
                $imagePath = str_replace(public_path() . '/', '', $actualOutputPath);
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
        $roomType->load(['bookings', 'roomImages']);
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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp,tiff|max:51200', // 50MB max (will be compressed)
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
                
                // Generate unique filename - prefer WebP but fallback to JPG
                $webpSupported = function_exists('imagewebp');
                $extension = $webpSupported ? '.webp' : '.jpg';
                $imageName = time() . '_' . uniqid() . $extension;
                $fullImagePath = public_path('upload/rooms/' . $imageName);
                
                // Ensure directory exists
                if (!file_exists(public_path('upload/rooms'))) {
                    mkdir(public_path('upload/rooms'), 0755, true);
                }
                
                // Convert and compress image
                $actualOutputPath = $this->convertToWebP($request->file('image_file'), $fullImagePath);
                
                // Update imagePath with actual saved file path
                $imagePath = str_replace(public_path() . '/', '', $actualOutputPath);
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

            DB::beginTransaction();

            // Delete main image if it exists
            if ($roomType->image_path && str_starts_with($roomType->image_path, 'upload/rooms/')) {
                $imagePath = public_path($roomType->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete all gallery images
            foreach ($roomType->roomImages as $roomImage) {
                if ($roomImage->image_path && str_starts_with($roomImage->image_path, 'upload/room-gallery/')) {
                    $imagePath = public_path($roomImage->image_path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }

            // Delete room type (cascade will handle room images)
            $roomType->delete();

            DB::commit();

            return redirect()->route('room-types.index')
                           ->with('success', 'Room type deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
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

    /**
     * Convert uploaded image to WebP format with compression (with fallback to JPEG)
     */
    private function convertToWebP($uploadedFile, $outputPath, $quality = 80)
    {
        // Check if WebP support is available
        $webpSupported = function_exists('imagewebp');
        
        // If WebP not supported, change output to JPEG
        if (!$webpSupported) {
            $outputPath = str_replace('.webp', '.jpg', $outputPath);
        }
        
        // Get the mime type of the uploaded file
        $mimeType = $uploadedFile->getMimeType();
        
        // Create image resource based on file type
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($uploadedFile->getPathname());
                break;
            case 'image/png':
                $image = imagecreatefrompng($uploadedFile->getPathname());
                // Preserve transparency for PNG
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($uploadedFile->getPathname());
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $image = imagecreatefromwebp($uploadedFile->getPathname());
                } else {
                    throw new \Exception('WebP format not supported by this server');
                }
                break;
            default:
                throw new \Exception('Unsupported image format: ' . $mimeType);
        }

        if (!$image) {
            throw new \Exception('Failed to create image resource from uploaded file');
        }

        // Get original dimensions
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Calculate new dimensions (max width/height: 1920px)
        $maxDimension = 1920;
        if ($originalWidth > $maxDimension || $originalHeight > $maxDimension) {
            if ($originalWidth > $originalHeight) {
                $newWidth = $maxDimension;
                $newHeight = intval(($originalHeight / $originalWidth) * $maxDimension);
            } else {
                $newHeight = $maxDimension;
                $newWidth = intval(($originalWidth / $originalHeight) * $maxDimension);
            }
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }

        // Create new image with calculated dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG/GIF (only if saving as WebP or PNG)
        if (($mimeType === 'image/png' || $mimeType === 'image/gif') && $webpSupported) {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        } elseif (!$webpSupported) {
            // For JPEG fallback, fill with white background
            $white = imagecolorallocate($resizedImage, 255, 255, 255);
            imagefill($resizedImage, 0, 0, $white);
        }

        // Resize the image
        imagecopyresampled(
            $resizedImage, $image, 
            0, 0, 0, 0, 
            $newWidth, $newHeight, 
            $originalWidth, $originalHeight
        );

        // Save in the best available format
        if ($webpSupported) {
            $result = imagewebp($resizedImage, $outputPath, $quality);
        } else {
            // Fallback to JPEG with high quality
            $result = imagejpeg($resizedImage, $outputPath, $quality);
        }

        // Clean up memory
        imagedestroy($image);
        imagedestroy($resizedImage);

        if (!$result) {
            $format = $webpSupported ? 'WebP' : 'JPEG';
            throw new \Exception("Failed to save {$format} image");
        }

        return $outputPath;
    }
}
