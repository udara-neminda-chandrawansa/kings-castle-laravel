<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_booking_id',
        'total_amount',
        'payment_status',
        'payment_reference',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'total_amount' => 'decimal:2'
    ];

    /**
     * Get the tour booking that owns the payment.
     */
    public function tourBooking()
    {
        return $this->belongsTo(TourBooking::class);
    }

    /**
     * Get the tour package through the booking.
     */
    public function tourPackage()
    {
        return $this->hasOneThrough(TourPackage::class, TourBooking::class, 'id', 'id', 'tour_booking_id', 'tour_package_id');
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute()
    {
        return 'LKR ' . number_format($this->total_amount, 2);
    }

    /**
     * Generate a unique payment reference
     */
    public static function generatePaymentReference()
    {
        do {
            $reference = 'TP' . date('Ymd') . rand(1000, 9999);
        } while (self::where('payment_reference', $reference)->exists());

        return $reference;
    }
}
