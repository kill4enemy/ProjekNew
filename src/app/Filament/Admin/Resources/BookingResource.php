<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    
    protected static ?string $navigationLabel = 'Bookings';
    
    protected static ?string $pluralModelLabel = 'Bookings';
    
    protected static ?string $modelLabel = 'Booking';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label('Nama Pemesan')
                    ->required(),

                Forms\Components\TextInput::make('customer_phone')
                    ->label('Nomor HP')
                    ->required(),

                Forms\Components\TextInput::make('customer_email')
                    ->label('Email')
                    ->email(),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(), // Nullable to support guest bookings

                Forms\Components\Select::make('facility_id')
                    ->relationship('facility', 'name')
                    ->label('Lapangan')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('booking_date')
                    ->label('Tanggal Main')
                    ->required(),

                Forms\Components\TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TextInput::make('total_price')
                    ->label('Total Harga')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending_payment' => 'Menunggu Pembayaran',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->default('pending_payment')
                    ->required()
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pemesan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('No HP'),

                Tables\Columns\TextColumn::make('facility.name')
                    ->label('Lapangan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Mulai'),

                Tables\Columns\TextColumn::make('end_time')
                    ->label('Selesai'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_payment' => 'Menunggu Pembayaran',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending_payment' => 'Menunggu Pembayaran',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
