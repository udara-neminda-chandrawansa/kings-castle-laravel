<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'room_type_id'
    ];

    /**
     * Get the booking that owns the booking room.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the room type that owns the booking room.
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
