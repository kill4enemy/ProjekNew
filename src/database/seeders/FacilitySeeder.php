<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::create([
            'name' => 'Lapangan 1',
            'type' => 'Outdoor',
            'description' => "✓ Outdoor\n✓ Raket pinjaman\n✓ Ruang tunggu\n✓ Area parkir",
            'price_per_hour' => 150000,
            'capacity' => 4,
            'is_active' => true,
            'image' => 'images/Lapangan1.jpg',
        ]);

        Facility::create([
            'name' => 'Lapangan 2',
            'type' => 'Outdoor',
            'description' => "✓ Outdoor\n✓ Raket pinjaman\n✓ Ruang tunggu\n✓ Area parkir",
            'price_per_hour' => 150000,
            'capacity' => 4,
            'is_active' => true,
            'image' => 'images/Lapangan2.jpg',
        ]);

        Facility::create([
            'name' => 'Lapangan VIP',
            'type' => 'Indoor',
            'description' => "✓ Indoor\n✓ Lampu malam\n✓ Ruang tunggu\n✓ Area parkir\n✓ Gratis 2 Pocari Botol",
            'price_per_hour' => 450000,
            'capacity' => 6,
            'is_active' => true,
            'image' => 'images/Lapangan.jpg',
        ]);
    }
}
