<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Migrations and seeders ran successfully.',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/', function () { return view('public-site.home'); });
Route::get('/about', function () { return view('public-site.about'); });
Route::get('/services', function () { return view('public-site.services'); });
Route::get('/packages', function () { return view('public-site.packages'); });
Route::get('/gallery', function () { return view('public-site.gallery'); });
Route::get('/contact', function () { return view('public-site.contact'); });
Route::get('/room-details/{id}', function ($id) { return view('public-site.room-details', ['id' => $id]); });

// Booking routes (public)
Route::post('/check-availability', [App\Http\Controllers\BookingController::class, 'checkAvailability'])->name('booking.check-availability');
Route::get('/book-room', [App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
Route::post('/book-room', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('booking.show');
Route::post('/booking/{booking}/payment', [App\Http\Controllers\BookingController::class, 'processPayment'])->name('booking.payment');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\BookingController::class, 'index'])->name('dashboard');
    
    // Admin booking management
    Route::get('/booking/{booking}/edit', [App\Http\Controllers\BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{booking}', [App\Http\Controllers\BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{booking}', [App\Http\Controllers\BookingController::class, 'destroy'])->name('booking.destroy');

    Route::get('/account', function () {
        return view('admin-dashboard.new-admin-account');
    })->name('dashboard.account');

    Route::put('/account/update', [UserController::class, 'update'])->name('account.update');
});
