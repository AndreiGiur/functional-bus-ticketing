<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Group for authenticated users with verified email
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Route (using DashboardController)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket Routes (handling purchases and subscriptions)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');  // List available tickets
    Route::post('/tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');  // Purchase a ticket
    Route::post('/tickets/subscribe', [TicketController::class, 'subscribe'])->name('tickets.subscribe');  // Subscribe route
    Route::post('/tickets/add-funds', [TicketController::class, 'addFunds'])->name('tickets.addFunds');
    // Add balance route
    Route::post('/tickets/add-funds', [TicketController::class, 'addFunds'])->name('tickets.addFunds');  // Add balance to user
});

Route::get('/login', function () {
    return view('login');
})->name('login');

require __DIR__.'/auth.php';
