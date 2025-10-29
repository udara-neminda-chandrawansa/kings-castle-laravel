<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\TourBookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment/notify', [BookingController::class, 'handleNotify'])->name('payment.api.notify');
Route::post('/tour-payment/notify', [TourBookingController::class, 'handlePaymentNotify'])->name('tour-payment.notify');