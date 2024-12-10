    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\TicketController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/login', function () {
        return view('login'); 
    })->name('login');

    Route::middleware('auth')->group(function () {
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Ticket Routes
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');
        Route::post('/tickets/1day', [TicketController::class, 'buy1Day'])->name('tickets.buy1day');
        Route::post('/tickets/subscribe', [TicketController::class, 'subscribe'])->name('tickets.subscribe');
    });

    require __DIR__.'/auth.php';

    Route::middleware('auth')->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');
        Route::post('/tickets/buy1day', [TicketController::class, 'buy1Day'])->name('tickets.buy1Day');
        Route::post('/tickets/subscribe', [TicketController::class, 'subscribe'])->name('tickets.subscribe');
    });
