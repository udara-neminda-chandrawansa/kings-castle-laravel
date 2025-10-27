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

    public function getFormattedPriceAttribute()
    {
        return 'Rs ' . number_format($this->price_per_night, 2);
    }
}
