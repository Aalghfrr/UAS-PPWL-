<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Room Management Routes
    Route::get('/rooms', [AdminController::class, 'rooms'])->name('rooms');
    Route::get('/rooms/{id}', [AdminController::class, 'getRoom'])->name('rooms.get');
    Route::post('/rooms', [AdminController::class, 'storeRoom'])->name('rooms.store');
    Route::put('/rooms/{id}', [AdminController::class, 'updateRoom'])->name('rooms.update');
    Route::delete('/rooms/{id}', [AdminController::class, 'deleteRoom'])->name('rooms.delete');
    
    // Facilities Routes
    Route::get('/facilities', [AdminController::class, 'facilities'])->name('facilities');
    Route::get('/facilities/{id}', [AdminController::class, 'getFacility'])->name('facilities.get');
    Route::post('/facilities', [AdminController::class, 'storeFacility'])->name('facilities.store');
    Route::put('/facilities/{id}', [AdminController::class, 'updateFacility'])->name('facilities.update');
    Route::delete('/facilities/{id}', [AdminController::class, 'deleteFacility'])->name('facilities.delete');
    
    // Booking Management
    Route::get('/bookings', [AdminController::class, 'allBookings'])->name('bookings');
    Route::post('/bookings/{id}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
    Route::post('/bookings/{id}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');
    Route::post('/bookings/{id}/complete', [AdminController::class, 'completeBooking'])->name('bookings.complete');
});

// User Routes 
Route::middleware(['auth'])->group(function () {
    // Dashboard User
    Route::get('/', [UserController::class, 'dashboard'])->name('user.dashboard');
    
    // Booking
    Route::get('/book/{type}/{id}', [UserController::class, 'bookingForm'])->name('user.booking.form');
    Route::post('/book', [UserController::class, 'storeBooking'])->name('user.booking.store');
    
    // History
    Route::get('/history', [UserController::class, 'history'])->name('user.history');
});

// Fallback route
Route::fallback(function () {
    return redirect()->route('login');
});