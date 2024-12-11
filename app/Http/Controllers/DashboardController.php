<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with balance and tickets.
     */
    public function index()
    {
        // Fetch the logged-in user's balance
        $balance = Auth::user()->balance;

        // Debugging: Dump the balance to ensure it's not null or empty
        if (is_null($balance)) {
            // Optionally, handle null balance scenario
            return redirect()->route('dashboard')->with('error', 'Balance is not set.');
        }

        // Fetch all available tickets from the Ticket model
        $tickets = Ticket::all();

        // Fetch the recent transactions of the logged-in user
        $recentTransactions = Auth::user()->transactions()->latest()->take(5)->get();

        // Return the dashboard view with the data
        return view('dashboard', compact('balance', 'tickets', 'recentTransactions'));
    }
}
