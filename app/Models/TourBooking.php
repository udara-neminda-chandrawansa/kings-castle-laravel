<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'tour_package_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_address',
        'guest_address_2',
        'participants',
        'tour_date',
        'special_requests',
        'status'
    ];

    protected $casts = [
        'tour_date' => 'date'
    ];

    /**
     * Get the tour package that owns the booking.
     */
    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    /**
     * Get the tour payment for this booking.
     */
    public function tourPayment()
    {
        return $this->hasOne(TourPayment::class);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default => 'warning'
        };
    }

    /**
     * Generate a unique booking reference
     */
    public static function generateBookingReference()
    {
        do {
            $reference = 'TB' . date('Ymd') . rand(1000, 9999);
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
