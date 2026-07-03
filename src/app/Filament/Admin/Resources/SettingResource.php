<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'About Sections';
    
    protected static ?string $pluralModelLabel = 'About Sections';
    
    protected static ?string $modelLabel = 'About Section';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Nama Pengaturan')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($state) => match($state) {
                        'business_name' => 'Nama Bisnis / Venue',
                        'business_description' => 'Deskripsi Bisnis',
                        'business_footer' => 'Teks Footer Website',
                        'open_time_monday' => 'Jam Buka - Senin',
                        'close_time_monday' => 'Jam Tutup - Senin',
                        'open_time_tuesday' => 'Jam Buka - Selasa',
                        'close_time_tuesday' => 'Jam Tutup - Selasa',
                        'open_time_wednesday' => 'Jam Buka - Rabu',
                        'close_time_wednesday' => 'Jam Tutup - Rabu',
                        'open_time_thursday' => 'Jam Buka - Kamis',
                        'close_time_thursday' => 'Jam Tutup - Kamis',
                        'open_time_friday' => 'Jam Buka - Jumat',
                        'close_time_friday' => 'Jam Tutup - Jumat',
                        'open_time_saturday' => 'Jam Buka - Sabtu',
                        'close_time_saturday' => 'Jam Tutup - Sabtu',
                        'open_time_sunday' => 'Jam Buka - Minggu',
                        'close_time_sunday' => 'Jam Tutup - Minggu',
                        default => ucwords(str_replace('_', ' ', $state))
                    })
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('value')
                    ->label('Nilai Konfigurasi')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Pengaturan')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'business_name' => 'Nama Bisnis / Venue',
                        'business_description' => 'Deskripsi Bisnis',
                        'business_footer' => 'Teks Footer Website',
                        'open_time_monday' => 'Jam Buka - Senin',
                        'close_time_monday' => 'Jam Tutup - Senin',
                        'open_time_tuesday' => 'Jam Buka - Selasa',
                        'close_time_tuesday' => 'Jam Tutup - Selasa',
                        'open_time_wednesday' => 'Jam Buka - Rabu',
                        'close_time_wednesday' => 'Jam Tutup - Rabu',
                        'open_time_thursday' => 'Jam Buka - Kamis',
                        'close_time_thursday' => 'Jam Tutup - Kamis',
                        'open_time_friday' => 'Jam Buka - Jumat',
                        'close_time_friday' => 'Jam Tutup - Jumat',
                        'open_time_saturday' => 'Jam Buka - Sabtu',
                        'close_time_saturday' => 'Jam Tutup - Sabtu',
                        'open_time_sunday' => 'Jam Buka - Minggu',
                        'close_time_sunday' => 'Jam Tutup - Minggu',
                        default => ucwords(str_replace('_', ' ', $state))
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
