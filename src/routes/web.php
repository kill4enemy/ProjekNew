<?php
use App\Models\Booking;
use App\Models\Court;
use App\Models\ProjectReport;
use App\Models\AboutSection;
use App\Http\Controllers\BookingController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
Route::get('/', function () {
    $totalBookings = Booking::count();
    $totalCourts = Court::count();
    $courts = Court::whereNotNull('image')->get();
    $about = AboutSection::where('is_active', true)->latest()->first();
    return view('pages.home', compact('totalBookings', 'totalCourts','courts','about'));
});


Route::get('/booking', function () {
    $courts = \App\Models\Court::where('is_active', true)->get();

    return view('pages.booking', compact('courts'));
});

Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/courts', function (Request $request) {
    $selectedDate = $request->get('date', now()->toDateString());

    
    $courts = Court::with(['bookings' => function ($query) use ($selectedDate) {
        $query->where('booking_date', $selectedDate)
            ->where('status', 'confirmed')
            ->orderBy('start_time');
    }])->get();

    return view('pages.courts', compact('courts', 'selectedDate'));
});

    //diagram
Route::get('/diagram', function () {
    return view('pages.diagram');
});

Route::get('/showcase-report', function () {

    $report = ProjectReport::latest()->firstOrFail();

    return view('pages.showcase-report', compact('report'));
});

    //Midtrans route
Route::get('/payment/{booking}', function (Booking $booking) {
    return view('pages.payment', compact('booking'));
})->name('payment.show');
 
    //Invoice
Route::get('/invoice/{booking}', function (Booking $booking) {
    return view('pages.invoice', compact('booking'));
})->name('invoice.show');

Route::get('/payment/finish/{booking}', function (Booking $booking) {
    return redirect()->route('invoice.show', $booking)
        ->with('success', 'Pembayaran berhasil. Berikut invoice booking Anda.');
})->name('payment.finish');

