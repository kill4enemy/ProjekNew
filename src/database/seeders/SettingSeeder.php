<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'business_name' => 'Hans Padel',
            'business_footer' => '© 2026 Hans Padel. Semua Hak Dilindungi Undang-Undang.',
            
            // Main Card (Beranda Utama)
            'main_card_subtitle' => 'Hans Padel',
            'main_card_title' => 'Booking Lapangan Padel Jadi Lebih Mudah',
            'main_card_description' => 'Sistem Informasi Penyewaan Lapangan Padel Berbasis Web membantu pengguna melihat lapangan, memilih jadwal, dan melakukan pemesanan secara online.',
            
            // About US (Card 1)
            'about_title' => 'About US',
            'about_description' => 'Hans Padel adalah penyedia jasa penyewaan lapangan padel modern yang siap melayani kebutuhan olahraga Anda dengan fasilitas berkualitas tinggi.',
            'about_image' => 'images/About.jpg',
            
            // Jam Operasional (Senin - Minggu)
            'open_time_monday' => '08:00',
            'close_time_monday' => '22:00',
            'open_time_tuesday' => '08:00',
            'close_time_tuesday' => '22:00',
            'open_time_wednesday' => '08:00',
            'close_time_wednesday' => '22:00',
            'open_time_thursday' => '08:00',
            'close_time_thursday' => '22:00',
            'open_time_friday' => '08:00',
            'close_time_friday' => '22:00',
            'open_time_saturday' => '07:00',
            'close_time_saturday' => '23:00',
            'open_time_sunday' => '07:00',
            'close_time_sunday' => '23:00',

            // Informasi Lokasi
            'location_title' => 'Lokasi Kami',
            'location_address' => 'Jl. Contoh No. 123, Tangerang, Banten',
            'location_whatsapp' => '+62 812-8421-6264',
            'location_email' => 'raihanisad2007@gmail.com',
            'location_hours_weekday' => 'Senin - Jumat : 08.00 - 22.00',
            'location_hours_weekend' => 'Sabtu - Minggu : 07.00 - 23.00',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
