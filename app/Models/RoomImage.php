<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'image_path',
        'alt_text',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    /**
     * Get the room type that owns the image
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        return asset($this->image_path);
    }

    /**
     * Scope to get images ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
