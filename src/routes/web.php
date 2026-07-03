<?php

use App\Models\Booking;
use App\Models\Facility;
use App\Models\ProjectReport;
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
    
    $about = (object) [
        'title' => 'About US',
        'description' => 'Hans Padel adalah sistem informasi penyewaan lapangan padel berbasis web yang membantu pengguna melihat lapangan, mengecek jadwal, dan melakukan booking secara online dengan lebih mudah. Projek ini dibuat untuk syarat dan kebutuhan untuk tugas akhir Mata Kuliah Pemrograman Web',
        'image' => 'images/About.jpg'
    ];

    return view('pages.home', compact('totalBookings', 'totalCourts', 'courts', 'about'));
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

// Showcase Report Page
Route::get('/showcase-report', function () {
    $report = ProjectReport::latest()->firstOrFail();

    return view('pages.showcase-report', compact('report'));
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
            BookingController::syncStatus($booking);
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
