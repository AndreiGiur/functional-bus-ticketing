<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Services\balance; // Import the balance service
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $balanceService;

    /**
     * Inject the balance service into the controller.
     */
    public function __construct(balance $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Show the user dashboard with balance and tickets.
     */
    public function index()
    {
        // Fetch the logged-in user's balance from the balance service
        $balance = $this->balanceService->getUserBalance();

        // Optional: Handle null or invalid balance scenario
        if ($balance === 0.0) {
            // Optionally customize how no balance data is handled
        }

        // Fetch all available tickets from the Ticket model
        $tickets = Ticket::all();

        // Fetch the recent transactions of the logged-in user
        $recentTransactions = Auth::user()->transactions()->latest()->take(5)->get();

        // Return the dashboard view with the data
        return view('dashboard', compact('balance', 'tickets', 'recentTransactions'));
    }
}
