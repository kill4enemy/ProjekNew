<?php

namespace App\Filament\Admin\Resources\BookingResource\Pages;

use App\Filament\Admin\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use App\Mail\BookingCancelledMail;
use App\Mail\BookingConfirmedMail;
use Illuminate\Support\Facades\Mail;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $oldStatus = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->oldStatus = $this->record->status;

        return $data;
    }

    protected function afterSave(): void
    {
         $booking = $this->record->fresh(['facility']);

         if ($this->oldStatus !== 'confirmed' && $booking->status === 'confirmed') {
             Mail::to($booking->customer_email)
                 ->send(new BookingConfirmedMail($booking));
         }

         if ($this->oldStatus !== 'cancelled' && $booking->status === 'cancelled') {
             Mail::to($booking->customer_email)
                 ->send(new BookingCancelledMail($booking));
         }
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
