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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,bmp,tiff|max:51200', // 50MB max (will be compressed)
            'alt_texts' => 'nullable|array',
            'alt_texts.*' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $uploadedImages = [];
            $nextSortOrder = RoomImage::where('room_type_id', $roomType->id)->max('sort_order') + 1;

            foreach ($request->file('images') as $index => $image) {
                // Generate unique filename - prefer WebP but fallback to JPG
                $webpSupported = function_exists('imagewebp');
                $extension = $webpSupported ? '.webp' : '.jpg';
                $imageName = time() . '_' . uniqid() . $extension;
                $imagePath = 'upload/room-gallery/' . $imageName;
                $fullImagePath = public_path($imagePath);

                // Ensure directory exists
                if (!file_exists(public_path('upload/room-gallery'))) {
                    mkdir(public_path('upload/room-gallery'), 0755, true);
                }

                // Convert and compress image
                $actualOutputPath = $this->convertToWebP($image, $fullImagePath);
                
                // Update imagePath with actual saved file path
                $imagePath = str_replace(public_path(), '', $actualOutputPath);
                $imagePath = ltrim($imagePath, '/');

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

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Image deleted successfully!'
            // ]);

            return redirect()->route('room-images.index', $roomType)
                           ->with('success', 'Room image deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Room image delete error: ' . $e->getMessage());
            return redirect()->route('room-images.index', $roomType)
                           ->with('error', 'Failed to delete room image. Please try again.');
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
