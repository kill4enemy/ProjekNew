<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use App\Models\Facility;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Lapangan', Facility::count())
                ->icon('heroicon-o-building-office-2')
                ->color('success'),

            Stat::make('Total Booking', Booking::count())
                ->icon('heroicon-o-calendar-days')
                ->color('warning'),

            Stat::make('Booking Confirmed', Booking::where('status', 'confirmed')->count())
                ->icon('heroicon-o-check-circle')
                ->color('primary'),
        ];
    }
}
