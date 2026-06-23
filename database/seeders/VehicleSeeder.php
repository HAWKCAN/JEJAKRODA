<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'rental_owner_id' => 1,
                'name' => 'Honda Beat 2023',
                'type' => 'motor',
                'plate_number' => 'R 1234 AB',
                'price_per_day' => 75000,
                'location' => 'Purwokerto Kota',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Honda Vario 160',
                'type' => 'motor',
                'plate_number' => 'R 5678 CD',
                'price_per_day' => 85000,
                'location' => 'Purwokerto Selatan',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Yamaha NMAX 155',
                'type' => 'motor',
                'plate_number' => 'R 9012 EF',
                'price_per_day' => 95000,
                'location' => 'Purwokerto Utara',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1622185135505-2d795003994a?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Toyota Avanza 2022',
                'type' => 'mobil',
                'plate_number' => 'R 3456 GH',
                'price_per_day' => 280000,
                'location' => 'Purwokerto Kota',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1623869675781-80aa31012a5a?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Daihatsu Xenia 2021',
                'type' => 'mobil',
                'plate_number' => 'R 7890 IJ',
                'price_per_day' => 260000,
                'location' => 'Purwokerto Timur',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1612825173281-9a193378527e?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Suzuki Ertiga 2023',
                'type' => 'mobil',
                'plate_number' => 'R 2468 KL',
                'price_per_day' => 300000,
                'location' => 'Purwokerto Barat',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1617469767053-d3b523a0b982?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Honda Scoopy 2022',
                'type' => 'motor',
                'plate_number' => 'R 1357 MN',
                'price_per_day' => 70000,
                'location' => 'Purwokerto Kota',
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1591637333472-6e2e1a2adb84?w=600&q=80',
            ],
            [
                'rental_owner_id' => 1,
                'name' => 'Mitsubishi Xpander 2023',
                'type' => 'mobil',
                'plate_number' => 'R 8642 OP',
                'price_per_day' => 320000,
                'location' => 'Purwokerto Selatan',
                'status' => 'rented',
                'image_url' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=600&q=80',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}