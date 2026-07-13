<?php

use App\Models\Booking;
use App\Models\Facility;
use App\Http\Controllers\BookingController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

use App\Http\Controllers\Auth\GoogleAuthController;

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

Route::get('/', function () {
    $totalBookings = Booking::where('status', 'confirmed')->count();
    $totalCourts = Facility::where('is_active', true)->count();
    $courts = Facility::where('is_active', true)->get();
    
    $aboutSettings = \App\Models\Setting::whereIn('key', [
        'about_title',
        'about_description',
        'about_image'
    ])->pluck('value', 'key');

    $about = (object) [
        'title' => $aboutSettings['about_title'] ?? 'About US',
        'description' => $aboutSettings['about_description'] ?? 'Hans Padel adalah penyedia jasa penyewaan lapangan padel modern yang siap melayani kebutuhan olahraga Anda dengan fasilitas berkualitas tinggi.',
        'image' => $aboutSettings['about_image'] ?? 'images/About.jpg'
    ];

    $locationSettings = \App\Models\Setting::whereIn('key', [
        'location_title',
        'location_address',
        'location_whatsapp',
        'location_email',
        'location_hours_weekday',
        'location_hours_weekend'
    ])->pluck('value', 'key');

    $mainCardSettings = \App\Models\Setting::whereIn('key', [
        'main_card_subtitle',
        'main_card_title',
        'main_card_description'
    ])->pluck('value', 'key');

    return view('pages.home', compact('totalBookings', 'totalCourts', 'courts', 'about', 'locationSettings', 'mainCardSettings'));
});

Route::get('/booking', function () {
    $courts = Facility::where('is_active', true)->get();

    return view('pages.booking', compact('courts'));
});

Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/courts', function (Request $request) {
    $selectedDate = $request->get('date', now()->toDateString());
    
    $courts = Facility::with(['bookings' => function ($query) use ($selectedDate) {
        $query->where('booking_date', $selectedDate)
            ->where('status', 'confirmed')
            ->orderBy('start_time');
    }])->where('is_active', true)->get();

    return view('pages.courts', compact('courts', 'selectedDate'));
});

// Diagram Page
Route::get('/diagram', function () {
    return view('pages.diagram');
});

// Midtrans Payment Page
Route::get('/payment/{booking}', function (Booking $booking) {
    return view('pages.payment', compact('booking'));
})->name('payment.show');
 
// Invoice Page
Route::get('/invoice/{booking}', function (Booking $booking) {
    BookingController::syncStatus($booking);
    return view('pages.invoice', compact('booking'));
})->name('invoice.show');

Route::get('/payment/finish/{booking}', function (Booking $booking) {
    BookingController::syncStatus($booking);
    return redirect()->route('invoice.show', $booking)
        ->with('success', 'Pembayaran berhasil. Berikut invoice booking Anda.');
})->name('payment.finish');

Route::get('/riwayat-transaksi', function () {
    $bookings = Booking::where('user_id', auth()->id())
        ->with('court')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    foreach ($bookings as $booking) {
        if ($booking->status === 'pending_payment') {
            $booking = BookingController::syncStatus($booking);
            if ($booking->status === 'pending_payment' && $booking->created_at->addHour()->isPast()) {
                $booking->update(['status' => 'cancelled']);
            }
        }
    }

    // Refresh collection to reflect updated status in the view
    $bookings = Booking::where('user_id', auth()->id())
        ->with('court')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('pages.transactions', compact('bookings'));
})->middleware(['auth'])->name('transactions.history');

Route::post('/logout', function (Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
