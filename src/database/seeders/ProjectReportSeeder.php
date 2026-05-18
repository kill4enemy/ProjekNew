<?php

namespace Database\Seeders;
use App\Models\ProjectReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectReport::create([
            'title' => 'Sistem Informasi Penyewaan Lapangan Padel Berbasis Web',

            'short_description' => 'Sistem ini dibuat untuk membantu proses penyewaan lapangan padel secara online agar lebih mudah, cepat, dan terorganisir. Pengguna dapat melihat informasi lapangan, memilih jadwal, dan melakukan booking, sedangkan admin dapat mengelola data lapangan, jadwal, dan pemesanan melalui panel admin berbasis web.',

            'problem_analysis' => 'Proses penyewaan lapangan padel yang masih dilakukan secara manual dapat menyebabkan beberapa masalah, seperti pencatatan data yang tidak rapi, risiko jadwal bentrok, sulitnya melihat ketersediaan lapangan, serta lambatnya proses konfirmasi pemesanan. Pengelola juga kesulitan dalam mengatur data pelanggan dan jadwal penyewaan secara terpusat. Oleh karena itu, diperlukan sistem berbasis web yang dapat membantu pengelolaan penyewaan lapangan menjadi lebih efisien, terstruktur, dan mudah diakses.',

            'system_requirements' => 'Sistem memiliki fitur utama berupa pengelolaan data lapangan, pengelolaan data booking, pengelolaan jadwal penyewaan, dan manajemen pengguna. Admin dapat menambah, mengubah, dan menghapus data melalui panel admin Filament. Sistem juga menyediakan fitur pengecekan jadwal agar tidak terjadi bentrokan waktu penyewaan antar pelanggan.',

            'architecture' => 'Sistem dibangun menggunakan konsep MVC (Model View Controller) dengan framework Laravel. Filament digunakan sebagai admin panel untuk mempermudah pengelolaan data, sedangkan Blade digunakan untuk tampilan frontend website. Database MariaDB digunakan sebagai penyimpanan data utama dan Docker digunakan untuk mempermudah proses development dan deployment environment.',

            'tech_stack' => 'Laravel 12, Filament v3, Livewire, Blade, MariaDB, Docker, dan Tailwind CSS.',

            'progress_status' => 'in_progress',
            'diagram_image' => 'null',
        ]);
    }
}
