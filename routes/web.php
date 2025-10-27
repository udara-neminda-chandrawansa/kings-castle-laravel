<?php

use App\Http\Controllers\BookingController;
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

Route::get('/', function () {
    return view('public-site.home');
});
Route::get('/about', function () {
    return view('public-site.about');
});
Route::get('/services', function () {
    $roomTypes = App\Models\RoomType::all();
    return view('public-site.services', compact('roomTypes'));
});
Route::get('/packages', function () {
    $tourPackages = App\Models\TourPackage::where('is_active', true)->get();
    return view('public-site.packages', compact('tourPackages'));
});
Route::get('/gallery', function () {
    return view('public-site.gallery');
});
Route::get('/contact', function () {
    return view('public-site.contact');
});
Route::get('/room-details/{id}', function ($id) {
    return view('public-site.room-details', ['id' => $id]);
});

// Booking routes (public)
Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check-availability');
Route::get('/book-room', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book-room', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/booking/{id}/payment', [BookingController::class, 'processPayment'])->name('booking.payment');
Route::get('/booking/{id}/payment-redirect', [BookingController::class, 'paymentRedirect'])->name('payment.redirect');

Route::get('/payment/return', [BookingController::class, 'handleReturn'])->name('payment.return');
Route::get('/payment/cancel', [BookingController::class, 'handleCancel'])->name('payment.cancel');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->group(function () {

    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');

    // Admin booking management
    Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

    // Room type management
    Route::resource('room-types', App\Http\Controllers\RoomTypeController::class);
    Route::patch('/room-types/{roomType}/toggle-status', [App\Http\Controllers\RoomTypeController::class, 'toggleStatus'])->name('room-types.toggle-status');

    // Tour package management
    Route::resource('tour-packages', App\Http\Controllers\TourPackageController::class);
    Route::patch('/tour-packages/{tourPackage}/toggle-status', [App\Http\Controllers\TourPackageController::class, 'toggleStatus'])->name('tour-packages.toggle-status');

    Route::get('/account', function () {
        return view('admin-dashboard.new-admin-account');
    })->name('dashboard.account');

    Route::put('/account/update', [UserController::class, 'update'])->name('account.update');
});
