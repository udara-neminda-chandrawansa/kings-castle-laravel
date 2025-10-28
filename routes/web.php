<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomImageController;
use App\Http\Controllers\TourPackageController;

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
        // Artisan::call('db:seed', ['--force' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Migrations ran successfully.',
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
    $roomTypes = App\Models\RoomType::where('is_active', true)->get();
    return view('public-site.home', compact('roomTypes'));
});
Route::get('/about', function () {
    return view('public-site.about');
});
Route::get('/services', function () {
    $roomTypes = App\Models\RoomType::where('is_active', true)->get();
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
    $roomType = App\Models\RoomType::with('roomImages')->findOrFail($id);
    return view('public-site.room-details', compact('roomType'));
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
    
    // Email management routes
    Route::post('/booking/{id}/send-confirmation', [BookingController::class, 'sendBookingConfirmation'])->name('booking.send-confirmation');
    Route::post('/booking/{id}/send-payment-confirmation', [BookingController::class, 'sendPaymentConfirmation'])->name('booking.send-payment-confirmation');
    Route::post('/booking/{id}/send-status-update', [BookingController::class, 'sendStatusUpdate'])->name('booking.send-status-update');

    // Room type management
    Route::resource('room-types', RoomTypeController::class);
    Route::patch('/room-types/{roomType}/toggle-status', [RoomTypeController::class, 'toggleStatus'])->name('room-types.toggle-status');
    
    // Room image management
    Route::get('/room-types/{roomType}/images', [RoomImageController::class, 'index'])->name('room-images.index');
    Route::post('/room-types/{roomType}/images', [RoomImageController::class, 'store'])->name('room-images.store');
    Route::put('/room-types/{roomType}/images/{roomImage}', [RoomImageController::class, 'update'])->name('room-images.update');
    Route::delete('/room-types/{roomType}/images/{roomImage}', [RoomImageController::class, 'destroy'])->name('room-images.destroy');
    Route::post('/room-types/{roomType}/images/sort-order', [RoomImageController::class, 'updateSortOrder'])->name('room-images.sort-order');
    
    // Debug route for testing
    Route::post('/debug/test-json', function() {
        return response()->json(['success' => true, 'message' => 'Test successful']);
    })->name('debug.test');

    // Tour package management
    Route::resource('tour-packages', TourPackageController::class);
    Route::patch('/tour-packages/{tourPackage}/toggle-status', [TourPackageController::class, 'toggleStatus'])->name('tour-packages.toggle-status');

    Route::get('/account', function () {
        return view('admin-dashboard.new-admin-account');
    })->name('dashboard.account');

    Route::put('/account/update', [UserController::class, 'update'])->name('account.update');
});
