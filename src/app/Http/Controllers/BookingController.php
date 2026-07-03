<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Court;
use App\Mail\BookingCancelledMail;
use App\Mail\BookingConfirmedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'court_id' => ['required', 'exists:courts,id'],
            'booking_date' => ['required', 'date'],
            'start_time' => ['required'],
            'duration' => ['required', 'integer', 'min:1', 'max:3'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
        ]);
            $court = Court::findOrFail($request->court_id);

            $startTime = Carbon::parse($request->start_time);
            $endTime = $startTime->copy()->addHours((int) $request->duration);

            $dayOfWeek = Carbon::parse($request->booking_date)->dayOfWeek;

            // Logic Jam Operational
            $isWeekend = in_array($dayOfWeek, [
                Carbon::SATURDAY,
                Carbon::SUNDAY,
            ]);

            $openTime = $isWeekend ? '07:00:00' : '08:00:00';
            $closeTime = $isWeekend ? '23:00:00' : '22:00:00';

            if (
                $startTime->format('H:i:s') < $openTime ||
                $endTime->format('H:i:s') > $closeTime
            ) {
                return back()
                    ->withInput()
                    ->with('error', 'Jam reservasi berada di luar jam operasional.');
            }
            
            $isBooked = Booking::where('court_id', $request->court_id)
                ->where('booking_date', $request->booking_date)
                ->where('status', 'confirmed')
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
                    'user_id' => 1,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_email' => $request->customer_email,
                    'court_id' => $request->court_id,
                    'booking_date' => $request->booking_date,
                    'start_time' => $startTime->format('H:i:s'),
                    'end_time' => $endTime->format('H:i:s'),
                    'total_price' => $court->price_per_hour * (int) $request->duration,
                    'status' => 'pending_payment',
                ]);

                $booking->update([
                    'booking_code' => 'HANS-' . now()->format('Ymd') . '-' . $booking->id,
                    'midtrans_order_id' => 'HANS-' . now()->format('YmdHis') . '-' . $booking->id,
                ]);

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

                $snapToken = Snap::getSnapToken($params);

                $booking->update([
                    'snap_token' => $snapToken,
                ]);

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

        if (in_array($request->transaction_status, ['capture', 'settlement'])) {
            if ($booking->status !== 'confirmed') {
                $booking->update([
                    'status' => 'confirmed',
                    'payment_type' => $request->payment_type,
                    'transaction_status' => $request->transaction_status,
                    'paid_at' => now(),
                ]);

                if ($booking->customer_email) {
                    Mail::to($booking->customer_email)
                        ->queue(new BookingConfirmedMail($booking->fresh(['court'])));
                }
            }
        }

        if ($request->transaction_status === 'pending') {
            $booking->update([
                'status' => 'pending_payment',
                'payment_type' => $request->payment_type,
                'transaction_status' => $request->transaction_status,
            ]);
        }

        if (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
            if ($booking->status !== 'cancelled') {
                $booking->update([
                    'status' => 'cancelled',
                    'payment_type' => $request->payment_type,
                    'transaction_status' => $request->transaction_status,
                ]);

                if ($booking->customer_email) {
                    Mail::to($booking->customer_email)
                        ->queue(new BookingCancelledMail($booking->fresh(['court'])));
                }
            }
        }

        return response()->json([
            'message' => 'Callback processed',
        ]);
    }

}
