<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'price',
        'price_unit',
        'duration',
        'includes',
        'image_path',
        'notes',
        'difficulty_level',
        'min_participants',
        'max_participants',
        'is_active'
    ];

    protected $casts = [
        'includes' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function getFormattedPriceAttribute()
    {
        if ($this->price) {
            return '$' . number_format($this->price, 0) . ' ' . $this->price_unit;
        }
        return 'Contact for pricing';
    }

    public function getDifficultyBadgeAttribute()
    {
        return match($this->difficulty_level) {
            'easy' => 'success',
            'moderate' => 'warning',
            'challenging' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get all tour bookings for this package.
     */
    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    /**
     * Get all tour payments for this package through bookings.
     */
    public function tourPayments()
    {
        return $this->hasManyThrough(TourPayment::class, TourBooking::class);
    }
}
