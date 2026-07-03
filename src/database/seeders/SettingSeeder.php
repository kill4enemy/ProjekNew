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
            'business_description' => 'Hans Padel adalah penyedia jasa penyewaan lapangan padel modern yang siap melayani kebutuhan olahraga Anda dengan fasilitas berkualitas tinggi.',
            'business_footer' => '© 2026 Hans Padel. Semua Hak Dilindungi Undang-Undang.',
            
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
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
