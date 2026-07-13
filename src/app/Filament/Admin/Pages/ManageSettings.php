<?php

namespace App\Filament\Admin\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Halaman';
    protected static ?string $title = 'Pengaturan Halaman & Lokasi';
    protected static ?string $slug = 'manage-settings';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.admin.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pengaturan Umum')
                    ->description('Pengaturan nama dan footer website.')
                    ->schema([
                        TextInput::make('business_name')->label('Nama Bisnis / Venue')->required(),
                        TextInput::make('business_footer')->label('Teks Footer Website')->required(),
                    ]),
                Section::make('Main Card (Beranda Utama)')
                    ->description('Pengaturan teks pada kartu utama di halaman depan.')
                    ->schema([
                        TextInput::make('main_card_subtitle')->label('Teks Kecil (Subtitle)')->required(),
                        TextInput::make('main_card_title')->label('Judul Utama (Bold)')->required(),
                        Textarea::make('main_card_description')->label('Deskripsi Singkat')->required()->rows(3),
                    ]),
                Section::make('Card 1 (Tentang Kami)')
                    ->description('Pengaturan konten Card 1 (Tentang Kami) di halaman beranda.')
                    ->schema([
                        TextInput::make('about_title')->label('Judul')->required(),
                        Textarea::make('about_description')->label('Deskripsi')->required()->rows(4),
                        \Filament\Forms\Components\FileUpload::make('about_image')
                            ->label('Gambar')
                            ->image()
                            ->directory('about-images')
                            ->required(),
                    ]),
                Section::make('Card 2 (Lokasi Kami)')
                    ->description('Pengaturan lokasi dan kontak yang ditampilkan di halaman beranda.')
                    ->schema([
                        TextInput::make('location_title')->label('Judul Lokasi')->required(),
                        Textarea::make('location_address')->label('Alamat Lengkap')->required(),
                        TextInput::make('location_whatsapp')->label('WhatsApp')->required(),
                        TextInput::make('location_email')->label('Email')->required(),
                        TextInput::make('location_hours_weekday')->label('Jam Operasional (Weekday)')->required(),
                        TextInput::make('location_hours_weekend')->label('Jam Operasional (Weekend)')->required(),
                    ]),
                Section::make('Jam Operasional Booking')
                    ->description('Pengaturan jam buka dan tutup lapangan setiap harinya.')
                    ->schema([
                        TextInput::make('open_time_monday')->label('Jam Buka - Senin')->type('time')->required(),
                        TextInput::make('close_time_monday')->label('Jam Tutup - Senin')->type('time')->required(),
                        TextInput::make('open_time_tuesday')->label('Jam Buka - Selasa')->type('time')->required(),
                        TextInput::make('close_time_tuesday')->label('Jam Tutup - Selasa')->type('time')->required(),
                        TextInput::make('open_time_wednesday')->label('Jam Buka - Rabu')->type('time')->required(),
                        TextInput::make('close_time_wednesday')->label('Jam Tutup - Rabu')->type('time')->required(),
                        TextInput::make('open_time_thursday')->label('Jam Buka - Kamis')->type('time')->required(),
                        TextInput::make('close_time_thursday')->label('Jam Tutup - Kamis')->type('time')->required(),
                        TextInput::make('open_time_friday')->label('Jam Buka - Jumat')->type('time')->required(),
                        TextInput::make('close_time_friday')->label('Jam Tutup - Jumat')->type('time')->required(),
                        TextInput::make('open_time_saturday')->label('Jam Buka - Sabtu')->type('time')->required(),
                        TextInput::make('close_time_saturday')->label('Jam Tutup - Sabtu')->type('time')->required(),
                        TextInput::make('open_time_sunday')->label('Jam Buka - Minggu')->type('time')->required(),
                        TextInput::make('close_time_sunday')->label('Jam Tutup - Minggu')->type('time')->required(),
                    ])->columns(2)
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
