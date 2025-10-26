<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourPackage;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $tourPackages = [
            [
                'name' => 'Helicopter Tour',
                'subtitle' => 'Soar Above the Highlands',
                'description' => 'Experience the breathtaking beauty of Sri Lanka\'s hill country from above with our exclusive helicopter tour. Soar over lush tea plantations, misty mountains, and scenic valleys.',
                'price' => 110,
                'price_unit' => 'per pax',
                'duration' => '1 Hour',
                'includes' => ['Professional pilot', 'Safety briefing', 'Scenic route', 'Photo opportunities'],
                'image_path' => 'assets/img/tours/helicopter1.jpg',
                'notes' => 'Pre-booking Required | Conditions Apply',
                'difficulty_level' => 'easy',
                'min_participants' => 1,
                'max_participants' => 4,
                'is_active' => true
            ],
            [
                'name' => 'City Tour',
                'subtitle' => 'Explore the Queen of Hills',
                'description' => 'Discover the charm of Nuwara Eliya with our comprehensive city tour. Visit colonial buildings, beautiful gardens, and learn about the rich history of this hill station.',
                'price' => null,
                'price_unit' => 'per group',
                'duration' => 'Half Day',
                'includes' => ['Local guide', 'Transportation', 'Entry tickets', 'Refreshments'],
                'image_path' => 'assets/img/tours/GregoryLake.jpg',
                'notes' => 'Conditions Apply',
                'difficulty_level' => 'easy',
                'min_participants' => 2,
                'max_participants' => 8,
                'is_active' => true
            ],
            [
                'name' => 'World\'s End Tour',
                'subtitle' => 'Where Earth Meets Sky',
                'description' => 'Journey to one of Sri Lanka\'s most spectacular viewpoints at World\'s End in Horton Plains National Park. Witness the dramatic cliff drop and panoramic views.',
                'price' => null,
                'price_unit' => 'per pax',
                'duration' => 'Full Day',
                'includes' => ['National park entry', 'Guide service', 'Transportation', 'Light breakfast'],
                'image_path' => 'assets/img/tours/worldsEnd.jpg',
                'notes' => 'Early morning departure required',
                'difficulty_level' => 'moderate',
                'min_participants' => 2,
                'max_participants' => 12,
                'is_active' => true
            ],
            [
                'name' => 'Ella One-Day Tour',
                'subtitle' => 'Scenic Mountain Adventure',
                'description' => 'Explore the picturesque town of Ella with its stunning waterfalls, nine-arch bridge, and mountain views. A perfect day trip for nature lovers.',
                'price' => null,
                'price_unit' => 'per pax',
                'duration' => 'Full Day',
                'includes' => ['Transportation', 'Local guide', 'Lunch', 'Site visits'],
                'image_path' => 'assets/img/tours/waterfall1.jpg',
                'notes' => 'Comfortable walking shoes recommended',
                'difficulty_level' => 'moderate',
                'min_participants' => 2,
                'max_participants' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Lake Activities',
                'subtitle' => 'Water Sports Adventure',
                'description' => 'Enjoy exciting water sports activities on Gregory Lake including jet skiing, boat rides, and other water activities in the heart of Nuwara Eliya.',
                'price' => null,
                'price_unit' => 'per activity',
                'duration' => '2-3 Hours',
                'includes' => ['Safety equipment', 'Basic instruction', 'Equipment rental'],
                'image_path' => 'assets/img/tours/jetski1.jpg',
                'notes' => 'Subject to weather conditions',
                'difficulty_level' => 'moderate',
                'min_participants' => 1,
                'max_participants' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Horse Riding',
                'subtitle' => 'Countryside Experience',
                'description' => 'Experience the tranquil countryside of Nuwara Eliya on horseback. Suitable for beginners and experienced riders alike.',
                'price' => null,
                'price_unit' => 'per hour',
                'duration' => '1-2 Hours',
                'includes' => ['Horse rental', 'Safety helmet', 'Basic instruction', 'Guide accompaniment'],
                'image_path' => 'assets/img/tours/horseRiding.jpg',
                'notes' => 'Age and weight restrictions apply',
                'difficulty_level' => 'easy',
                'min_participants' => 1,
                'max_participants' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Bicycle Ride',
                'subtitle' => 'Eco-Friendly Exploration',
                'description' => 'Cycle through the scenic roads and tea plantations around Nuwara Eliya. An eco-friendly way to explore the beautiful landscape.',
                'price' => null,
                'price_unit' => 'per day',
                'duration' => 'Flexible',
                'includes' => ['Bicycle rental', 'Safety helmet', 'Route map', 'Basic maintenance'],
                'image_path' => 'assets/img/tours/cycling1.jpg',
                'notes' => 'Various routes available',
                'difficulty_level' => 'moderate',
                'min_participants' => 1,
                'max_participants' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Natural Tour',
                'subtitle' => 'Nature and Wildlife',
                'description' => 'Explore the natural beauty and wildlife of the region including Lover\'s Leap waterfall and surrounding forest areas.',
                'price' => null,
                'price_unit' => 'per pax',
                'duration' => 'Half Day',
                'includes' => ['Nature guide', 'Transportation', 'Light refreshments', 'Binoculars'],
                'image_path' => 'assets/img/tours/loversLeap1.jpg',
                'notes' => 'Weather dependent',
                'difficulty_level' => 'moderate',
                'min_participants' => 2,
                'max_participants' => 8,
                'is_active' => true
            ],
            [
                'name' => 'Tea Tasting & Workshop',
                'subtitle' => 'Ceylon Tea Experience',
                'description' => 'Learn about Sri Lanka\'s famous Ceylon tea with a comprehensive tasting session and workshop at a local tea factory.',
                'price' => null,
                'price_unit' => 'per pax',
                'duration' => '2-3 Hours',
                'includes' => ['Tea tasting session', 'Factory tour', 'Tea expert guide', 'Tea samples to take home'],
                'image_path' => 'assets/img/tours/teaTesting.jpg',
                'notes' => 'Educational and delicious',
                'difficulty_level' => 'easy',
                'min_participants' => 2,
                'max_participants' => 15,
                'is_active' => true
            ],
            [
                'name' => 'Hiking Experience',
                'subtitle' => 'Mountain Trekking',
                'description' => 'Challenge yourself with guided hiking experiences through the mountainous terrain around Nuwara Eliya including Shanthipura and other scenic trails.',
                'price' => null,
                'price_unit' => 'per pax',
                'duration' => '3-6 Hours',
                'includes' => ['Experienced guide', 'Trail snacks', 'First aid kit', 'Route planning'],
                'image_path' => 'assets/img/tours/shanthipura.jpg',
                'notes' => 'Good fitness level required',
                'difficulty_level' => 'challenging',
                'min_participants' => 2,
                'max_participants' => 8,
                'is_active' => true
            ],
            [
                'name' => 'VIP Nuwara Eliya Tour',
                'subtitle' => 'Premium Experience',
                'description' => 'Enjoy a premium tour experience of Nuwara Eliya with luxury transportation, exclusive access, and personalized service.',
                'price' => null,
                'price_unit' => 'per group',
                'duration' => 'Full Day',
                'includes' => ['Luxury vehicle', 'Personal guide', 'Premium lunch', 'Exclusive access', 'Photography service'],
                'image_path' => 'assets/img/tours/nuwaraEliya.jpg',
                'notes' => 'Advanced booking required',
                'difficulty_level' => 'easy',
                'min_participants' => 1,
                'max_participants' => 4,
                'is_active' => true
            ]
        ];

        foreach ($tourPackages as $package) {
            TourPackage::create($package);
        }
    }
}
