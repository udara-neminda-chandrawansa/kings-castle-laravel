<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
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
     * Get the booking that owns the payment.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
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
            $reference = 'PH' . date('Ymd') . rand(1000, 9999);
        } while (self::where('payment_reference', $reference)->exists());

        return $reference;
    }
}
