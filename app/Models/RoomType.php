<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'max_occupancy',
        'amenities',
        'image_path',
        'is_active'
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_rooms');
    }

    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class);
    }

    public function roomImages()
    {
        return $this->hasMany(RoomImage::class)->ordered();
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs ' . number_format($this->price_per_night, 2);
    }

    /**
     * Get all images for this room type (main + gallery)
     */
    public function getAllImagesAttribute()
    {
        $images = collect();
        
        // Add main image if exists
        if ($this->image_path) {
            $images->push((object)[
                'id' => 'main',
                'image_path' => $this->image_path,
                'alt_text' => $this->name . ' - Main Image',
                'is_main' => true
            ]);
        }
        
        // Add gallery images - check if relationship is loaded
        if ($this->relationLoaded('roomImages')) {
            $this->roomImages->each(function($image) use ($images) {
                $images->push((object)[
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text ?: $this->name,
                    'is_main' => false
                ]);
            });
        } else {
            // If relationship is not loaded, load it
            $this->load('roomImages');
            $this->roomImages->each(function($image) use ($images) {
                $images->push((object)[
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text ?: $this->name,
                    'is_main' => false
                ]);
            });
        }
        
        return $images;
    }

    /**
     * Get display images (limited for performance)
     */
    public function getDisplayImagesAttribute()
    {
        $allImages = $this->getAllImages;
        return $allImages ? $allImages->take(5) : collect(); // Limit to 5 images for display
    }

    /**
     * Check if room type has gallery images
     */
    public function hasGallery()
    {
        return $this->roomImages()->count() > 0;
    }
}
