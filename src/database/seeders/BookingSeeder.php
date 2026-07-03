<?php

namespace Database\Seeders;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'user_id' => 1,
            'customer_name' => 'Raihan Isad',
            'customer_phone' => '081234567890',
            'customer_email' => 'raihanisad2007@gmail.com',
            'facility_id' => 1,
            'booking_date' => now()->toDateString(),
            'start_time' => '19:00',
            'end_time' => Carbon::parse('19:00')->addHours(2)->format('H:i:s'),
            'total_price' => 300000,
            'status' => 'confirmed',
            'booking_code' => 'HANS-' . now()->format('Ymd') . '-1',
            'midtrans_order_id' => 'HANS-' . now()->format('YmdHis') . '-1',
        ]);
    }
}
