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
        // Ensure there is a logged-in user
        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route('login')->with('error', 'You must be logged in to access the dashboard.');
        }

        // Fetch the logged-in user's balance
        $balance = $user->balance;
        if (is_null($balance)) {
            // Handle null balance scenario, e.g., redirect to profile
            return redirect()->route('profile')->with('error', 'Please set your balance in your profile.');
        }

        // Fetch paginated tickets scoped to public or specific conditions
        $tickets = Ticket::latest()->paginate(config('app.pagination_limit', 20));

        // Fetch the recent transactions of the logged-in user
        $recentTransactions = $user->transactions()->latest()->take(5)->get() ?? collect();

        // Return the dashboard view with the data
        return view('dashboard', [
            'balance' => $balance,
            'tickets' => $tickets,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
