<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_address',
        'guest_address_2',
        'participants',
        'tour_date',
        'special_requests',
        'total_amount',
        'payment_status',
        'payment_reference',
        'payment_details',
        'status'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'total_amount' => 'decimal:2',
        'tour_date' => 'date'
    ];

    /**
     * Get the tour package that owns the payment.
     */
    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
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
