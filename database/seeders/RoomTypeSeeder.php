<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'Double Room',
                'description' => 'Comfortable double room perfect for couples, featuring modern amenities and beautiful views.',
                'price_per_night' => 30000.00,
                'max_occupancy' => 2,
                'amenities' => ['WiFi', 'Air Conditioning', 'Private Bathroom', 'TV', 'Mini Fridge'],
                'image_path' => 'assets/img/drive-images-2-webp/kc14.webp',
                'is_active' => true
            ],
            [
                'name' => 'Triple Room',
                'description' => 'Spacious triple room ideal for small families or groups of friends.',
                'price_per_night' => 37000.00,
                'max_occupancy' => 3,
                'amenities' => ['WiFi', 'Air Conditioning', 'Private Bathroom', 'TV', 'Mini Fridge', 'Extra Bed'],
                'image_path' => 'assets/img/drive-images-2-webp/kc1.webp',
                'is_active' => true
            ],
            [
                'name' => 'Sweet Double Room',
                'description' => 'Luxurious suite with separate living area, perfect for special occasions.',
                'price_per_night' => 65000.00,
                'max_occupancy' => 2,
                'amenities' => ['WiFi', 'Air Conditioning', 'Private Bathroom', 'TV', 'Mini Bar', 'Living Area', 'Balcony'],
                'image_path' => 'assets/img/drive-images-2-webp/kc32.webp',
                'is_active' => true
            ],
            [
                'name' => 'Sweet Triple Room',
                'description' => 'Premium suite with extra space and luxury amenities for up to 3 guests.',
                'price_per_night' => 75000.00,
                'max_occupancy' => 3,
                'amenities' => ['WiFi', 'Air Conditioning', 'Private Bathroom', 'TV', 'Mini Bar', 'Living Area', 'Balcony', 'Extra Bed'],
                'image_path' => 'assets/img/drive-images-2-webp/kc31.webp',
                'is_active' => true
            ]
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
