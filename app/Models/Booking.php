<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'room_type_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_address',
        'guest_address_2',
        'adults',
        'children',
        'check_in_date',
        'check_out_date',
        'nights',
        'status',
        'special_requests'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getFormattedTotalAttribute()
    {
        return $this->payment ? $this->payment->formatted_total : 'Rs 0.00';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'success',
            'checked_in' => 'info',
            'checked_out' => 'secondary',
            'cancelled' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public static function generateBookingReference()
    {
        do {
            $reference = 'KC' . strtoupper(substr(uniqid(), -8));
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }

    public function calculateNights()
    {
        return Carbon::parse($this->check_out_date)->diffInDays(Carbon::parse($this->check_in_date));
    }
}
