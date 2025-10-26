<?php

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

Route::get('/', function () { return view('public-site.home'); });
Route::get('/about', function () { return view('public-site.about'); });
Route::get('/services', function () { return view('public-site.services'); });
Route::get('/packages', function () { return view('public-site.packages'); });
Route::get('/gallery', function () { return view('public-site.gallery'); });
Route::get('/contact', function () { return view('public-site.contact'); });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
