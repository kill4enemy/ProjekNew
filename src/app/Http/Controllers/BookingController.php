<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Setting;
use App\Models\User;
use App\Mail\BookingCreatedMail;
use App\Mail\BookingConfirmedMail;
use App\Mail\BookingCancelledMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Filament\Notifications\Notification;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => ['required', 'exists:facilities,id'],
            'booking_date' => ['required', 'date'],
            'start_time' => ['required'],
            'duration' => ['required', 'integer', 'min:1', 'max:3'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
        ]);

        $facility = Facility::findOrFail($request->facility_id);

        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addHours((int) $request->duration);

        $dayName = strtolower(Carbon::parse($request->booking_date)->englishDayOfWeek); // e.g. "monday"

        // Dynamic Jam Operasional from Settings
        $openTimeSetting = Setting::getValue("open_time_{$dayName}", "08:00");
        $closeTimeSetting = Setting::getValue("close_time_{$dayName}", "22:00");

        $openTime = Carbon::parse($openTimeSetting)->format('H:i:s');
        $closeTime = Carbon::parse($closeTimeSetting)->format('H:i:s');

        if (
            $startTime->format('H:i:s') < $openTime ||
            $endTime->format('H:i:s') > $closeTime
        ) {
            return back()
                ->withInput()
                ->with('error', "Jam reservasi berada di luar jam operasional ({$openTimeSetting} - {$closeTimeSetting}).");
        }
        
        // Pengecekan double booking (status pending_payment atau confirmed)
        $isBooked = Booking::where('facility_id', $request->facility_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['confirmed', 'pending_payment'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime->format('H:i:s'))
                    ->where('end_time', '>', $startTime->format('H:i:s'));
            })
            ->exists();
    
        if ($isBooked) {
            return back()
                ->withInput()
                ->with('error', 'Waktu di jam tersebut sudah terisi. Silakan pilih jadwal lain.');
        }

        $booking = Booking::create([
            'user_id' => Auth::check() ? Auth::id() : null, // Nullable for guest booking
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'facility_id' => $request->facility_id,
            'booking_date' => $request->booking_date,
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'total_price' => $facility->price_per_hour * (int) $request->duration,
            'status' => 'pending_payment',
        ]);

        $booking->update([
            'booking_code' => 'HANS-' . now()->format('Ymd') . '-' . $booking->id,
            'midtrans_order_id' => 'HANS-' . now()->format('YmdHis') . '-' . $booking->id,
        ]);

        // Pembayaran dilakukan melalui midtrans, tidak mengirim email pending

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $booking->midtrans_order_id,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->customer_name,
                'email' => $booking->customer_email,
                'phone' => $booking->customer_phone,
            ],
            'callbacks' => [
                'finish' => route('payment.finish', $booking),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $booking->update([
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get Midtrans Snap Token: ' . $e->getMessage());
        }

        return redirect()->route('payment.show', $booking);
    }

    public function callback(Request $request)
    {
        Log::info('Midtrans callback received', $request->all());

        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            Log::warning('Invalid Midtrans signature', [
                'order_id' => $request->order_id,
            ]);

            return response()->json([
                'message' => 'Invalid signature',
            ], 403);
        }

        $booking = Booking::where('midtrans_order_id', $request->order_id)->first();

        if (! $booking) {
            Log::warning('Booking not found from Midtrans callback', [
                'order_id' => $request->order_id,
            ]);

            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        $statusChanged = false;
        $oldStatus = $booking->status;

        if (in_array($request->transaction_status, ['capture', 'settlement'])) {
            if ($booking->status !== 'confirmed') {
                $booking->update([
                    'status' => 'confirmed',
                    'payment_type' => $request->payment_type,
                    'transaction_status' => $request->transaction_status,
                    'midtrans_transaction_id' => $request->transaction_id,
                    'payment_verified_at' => now(),
                ]);
                $statusChanged = true;

                // Send email to customer (Synchronously via SMTP)
                if ($booking->customer_email) {
                    try {
                        Mail::to($booking->customer_email)
                            ->send(new BookingConfirmedMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingConfirmedMail to customer: ' . $e->getMessage());
                    }
                }

                // Send email notification to all admins (Synchronously via SMTP)
                $adminEmails = User::whereHas('roles', function($q) {
                    $q->where('name', 'super_admin');
                })->pluck('email')->toArray();

                if (!empty($adminEmails)) {
                    try {
                        Mail::to($adminEmails)->send(new BookingConfirmedMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingConfirmedMail to admins: ' . $e->getMessage());
                    }
                }

                // Send real-time database notification to admins
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
                        Log::error('Failed to send Filament database notification: ' . $e->getMessage());
                    }
                }
            }
        }

        if ($request->transaction_status === 'pending') {
            if ($booking->status !== 'pending_payment') {
                $booking->update([
                    'status' => 'pending_payment',
                    'payment_type' => $request->payment_type,
                    'transaction_status' => $request->transaction_status,
                ]);
            }
        }

        if (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
            if ($booking->status !== 'cancelled') {
                $booking->update([
                    'status' => 'cancelled',
                    'payment_type' => $request->payment_type,
                    'transaction_status' => $request->transaction_status,
                ]);
                $statusChanged = true;

                // Send email to customer (Synchronously via SMTP)
                if ($booking->customer_email) {
                    try {
                        Mail::to($booking->customer_email)
                            ->send(new BookingCancelledMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingCancelledMail to customer: ' . $e->getMessage());
                    }
                }

                // Send email notification to admins (Synchronously via SMTP)
                $adminEmails = User::whereHas('roles', function($q) {
                    $q->where('name', 'super_admin');
                })->pluck('email')->toArray();

                if (!empty($adminEmails)) {
                    try {
                        Mail::to($adminEmails)->send(new BookingCancelledMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingCancelledMail to admins: ' . $e->getMessage());
                    }
                }

                // Send real-time database notification to admins
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
                        Log::error('Failed to send Filament database notification: ' . $e->getMessage());
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Callback processed',
        ]);
    }

    public static function syncStatus(Booking $booking)
    {
        if ($booking->status !== 'pending_payment') {
            return $booking;
        }

        try {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            $status = \Midtrans\Transaction::status($booking->midtrans_order_id);

            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                $booking->update([
                    'status' => 'confirmed',
                    'payment_type' => $status->payment_type,
                    'transaction_status' => $status->transaction_status,
                    'midtrans_transaction_id' => $status->transaction_id,
                    'payment_verified_at' => now(),
                ]);

                // Send email to customer (Synchronously via SMTP)
                if ($booking->customer_email) {
                    try {
                        Mail::to($booking->customer_email)
                            ->send(new BookingConfirmedMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingConfirmedMail to customer in syncStatus: ' . $e->getMessage());
                    }
                }

                // Send email notification to all admins (Synchronously via SMTP)
                $adminEmails = User::whereHas('roles', function($q) {
                    $q->where('name', 'super_admin');
                })->pluck('email')->toArray();

                if (!empty($adminEmails)) {
                    try {
                        Mail::to($adminEmails)->send(new BookingConfirmedMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingConfirmedMail to admins in syncStatus: ' . $e->getMessage());
                    }
                }

                // Send real-time database notification to admins
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
                        Log::error('Failed to send Filament database notification in syncStatus: ' . $e->getMessage());
                    }
                }
            } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                $booking->update([
                    'status' => 'cancelled',
                    'payment_type' => $status->payment_type,
                    'transaction_status' => $status->transaction_status,
                ]);

                // Send email to customer (Synchronously via SMTP)
                if ($booking->customer_email) {
                    try {
                        Mail::to($booking->customer_email)
                            ->send(new BookingCancelledMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingCancelledMail to customer in syncStatus: ' . $e->getMessage());
                    }
                }

                // Send email notification to admins (Synchronously via SMTP)
                $adminEmails = User::whereHas('roles', function($q) {
                    $q->where('name', 'super_admin');
                })->pluck('email')->toArray();

                if (!empty($adminEmails)) {
                    try {
                        Mail::to($adminEmails)->send(new BookingCancelledMail($booking->fresh(['facility'])));
                    } catch (\Exception $e) {
                        Log::error('Failed to send BookingCancelledMail to admins in syncStatus: ' . $e->getMessage());
                    }
                }

                // Send real-time database notification to admins
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
                        Log::error('Failed to send Filament database notification in syncStatus: ' . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to sync Midtrans transaction status for booking ' . $booking->id . ': ' . $e->getMessage());
        }

        return $booking;
    }
}
