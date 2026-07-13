<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\BookingController as ApiBookingController;

Route::apiResource('facilities', FacilityController::class);
Route::apiResource('bookings', ApiBookingController::class);

Route::post('/midtrans/callback', [BookingController::class, 'callback'])
    ->name('midtrans.callback');