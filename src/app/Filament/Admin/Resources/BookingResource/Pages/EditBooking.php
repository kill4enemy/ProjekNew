<?php

namespace App\Filament\Admin\Resources\BookingResource\Pages;

use App\Filament\Admin\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use App\Mail\BookingCancelledMail;
use App\Mail\BookingConfirmedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

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
              // Send email confirmation
              Mail::to($booking->customer_email)
                  ->send(new BookingConfirmedMail($booking));

              // Send database notification to super admins
              $admins = User::whereHas('roles', function($q) {
                  $q->where('name', 'super_admin');
              })->get();

              foreach ($admins as $admin) {
                  try {
                      $notification = Notification::make()
                          ->title('Pembayaran Booking Berhasil')
                          ->body("Booking {$booking->booking_code} oleh {$booking->customer_name} telah dikonfirmasi.")
                          ->success();
                      $admin->notifyNow($notification->toDatabase());
                  } catch (\Exception $e) {
                      Log::error('Failed to send database notification in EditBooking: ' . $e->getMessage());
                  }
              }
         }

         if ($this->oldStatus !== 'cancelled' && $booking->status === 'cancelled') {
              // Send email cancellation
              Mail::to($booking->customer_email)
                  ->send(new BookingCancelledMail($booking));

              // Send database notification to super admins
              $admins = User::whereHas('roles', function($q) {
                  $q->where('name', 'super_admin');
              })->get();

              foreach ($admins as $admin) {
                  try {
                      $notification = Notification::make()
                          ->title('Booking Dibatalkan/Gagal')
                          ->body("Booking {$booking->booking_code} oleh {$booking->customer_name} telah dibatalkan.")
                          ->danger();
                      $admin->notifyNow($notification->toDatabase());
                  } catch (\Exception $e) {
                      Log::error('Failed to send database notification in EditBooking: ' . $e->getMessage());
                  }
              }
         }
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
