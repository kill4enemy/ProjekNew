<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FacilityResource\Pages;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Tables\Table;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationLabel = 'Facilities';
    
    protected static ?string $pluralModelLabel = 'Facilities';
    
    protected static ?string $modelLabel = 'Facility';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lapangan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('type')
                    ->label('Tipe Lapangan (e.g. Indoor, Outdoor, Vinyl, Sintetis)')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi / Fasilitas')
                    ->rows(4)
                    ->placeholder('Contoh: AC, ruang tunggu, parkir luas, shower, raket gratis.')
                    ->nullable(),

                Forms\Components\TextInput::make('price_per_hour')
                    ->label('Harga per Jam (IDR)')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('capacity')
                    ->label('Kapasitas Pemain (Pilihan)')
                    ->numeric()
                    ->nullable(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),

                FileUpload::make('image')
                    ->label('Gambar Lapangan')
                    ->image()
                    ->directory('facilities')
                    ->disk('public')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price_per_hour')
                    ->label('Harga per Jam')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }
}
