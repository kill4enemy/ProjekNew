<?php

use App\Models\User;
use App\Models\Booking;
use App\Models\Facility;

test('riwayat transaksi page requires authentication', function () {
    $response = $this->get('/riwayat-transaksi');

    $response->assertRedirect('/login');
});

test('riwayat transaksi page shows authenticated user bookings', function () {
    $user = User::factory()->create();
    $facility = Facility::create([
        'name' => 'Lapangan A',
        'type' => 'Indoor',
        'capacity' => 4,
        'price_per_hour' => 150000,
        'is_active' => true,
    ]);

    $booking = Booking::create([
        'user_id' => $user->id,
        'customer_name' => $user->name,
        'customer_phone' => '0812345678',
        'customer_email' => $user->email,
        'facility_id' => $facility->id,
        'booking_date' => now()->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'total_price' => 150000,
        'status' => 'pending_payment',
        'booking_code' => 'HANS-TEST-01',
    ]);

    $this->actingAs($user);

    $response = $this->get('/riwayat-transaksi');

    $response->assertOk();
    $response->assertSee('Riwayat Transaksi');
    $response->assertSee('HANS-TEST-01');
    $response->assertSee('Lapangan A');
    $response->assertSee('Menunggu Pembayaran');
});
