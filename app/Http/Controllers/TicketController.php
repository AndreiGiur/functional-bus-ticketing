<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Display the available tickets and user's purchase history
    public function index()
    {
        // Fetch all available tickets from the database
        $availableTickets = Ticket::all();

        // Fetch the user's purchase history (limit to a certain number of recent purchases)
        $purchasedTickets = Transaction::where('user_id', Auth::id())
            ->where('type', 'ticket_purchase') // Ensure we only get ticket purchase transactions
            ->orderBy('created_at', 'desc')
            ->with('ticket') // Eager load the ticket relation
            ->get();

        // Return the view with available tickets and the user's purchase history
        return view('tickets.index', compact('availableTickets', 'purchasedTickets'));
    }

    // Handle the ticket purchase
    public function buy(Request $request)
    {
        // Validate the request to ensure the ticket type is selected
        $validated = $request->validate([
            'ticketType' => 'required|in:1,2,3', // Ticket type (1: 90-min, 2: 1-day, 3: Monthly)
        ]);

        // Assume ticket prices for each type (adjust as per your logic)
        $ticketPrices = [
            1 => 3,   // 90-minute ticket
            2 => 15,  // 1-Day Subscription
            3 => 80,  // Monthly Subscription
        ];

        // Get the selected ticket type and its price
        $ticketType = $request->input('ticketType');
        $price = $ticketPrices[$ticketType];

        // Fetch the user's balance
        $user = Auth::user();
        $balance = $user->balance;

        // Check if the user has enough balance
        if ($balance < $price) {
            return redirect()->route('tickets.index')->with('status', 'Fonduri insuficiente pentru achiziționarea biletului.');
        }

        // Deduct the balance
        $user->balance -= $price;
        $user->save();

        // Create a new transaction to record the purchase
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'ticket_purchase',
            'status' => 'completed',
        ]);

        // Redirect back to the tickets page with a success message
        return redirect()->route('tickets.index')->with('status', 'Bilet cumpărat cu succes!');
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'ticketType' => 'required|in:2,3', // Only allow 1-day or monthly subscriptions
        ]);

        $ticketPrices = [
            2 => 15,  // 1-Day Subscription
            3 => 80,  // Monthly Subscription
        ];

        $ticketType = $request->input('ticketType');
        $price = $ticketPrices[$ticketType];

        $user = Auth::user();
        $balance = $user->balance;

        if ($balance < $price) {
            return redirect()->route('tickets.index')->with('status', 'Fonduri insuficiente pentru achiziționarea abonamentului.');
        }

        $user->balance -= $price;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'subscription_purchase',
            'status' => 'completed',
        ]);

        return redirect()->route('tickets.index')->with('status', 'Abonament cumpărat cu succes!');
    }

    public function addFunds(Request $request)
    {
        // Validate the amount input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1', // The minimum amount to add is 1
        ]);

        // Fetch the authenticated user
        $user = Auth::user();
        $amount = $request->input('amount');

        // Add funds to the user's balance
        $user->balance += $amount;
        $user->save();

        // Create a transaction for the fund addition
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'fund_addition',
            'status' => 'completed',
        ]);

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('status', 'Fonduri adăugate cu succes!');
    }
}
