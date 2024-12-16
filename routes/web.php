<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Group for authenticated users with verified emails
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes with authorization
    Route::middleware('can:update,App\Models\User')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Account deletion route
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket Routes
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index'); // List of tickets
        Route::post('/buy', [TicketController::class, 'buy'])->name('buy'); // General ticket purchase route
        Route::post('/buy/1-day', [TicketController::class, 'buy1Day'])->name('buy1Day'); // 1-day ticket purchase route
        Route::post('/subscribe', [TicketController::class, 'subscribe'])->name('subscribe'); // Subscribe to a monthly pass
        Route::post('/add-balance', [TicketController::class, 'addFunds'])->name('addFunds'); // Add funds to user's account
    });
});

// Login Route (if not authenticated)
Route::get('/login', function () {
    return view('login');
})->name('login');

require __DIR__.'/auth.php';
