<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\PurchasedTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display the available tickets and user's purchase history.
     */
    public function index(): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('You must be logged in to view tickets.'));
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', __('Session expired. Please log in again.'));
        }

        $paginateLimit = config('app.pagination_limit', 20);
        $availableTickets = Ticket::where('status', 'available')->paginate($paginateLimit);

        $purchasedTickets = PurchasedTicket::where('user_id', $user->id)
            ->with('ticket:id,type,price')
            ->orderBy('created_at', 'desc')
            ->paginate($paginateLimit);

        return view('tickets.index', compact('availableTickets', 'purchasedTickets'));
    }

    /**
     * Handle the ticket purchase.
     */
    public function buy(Request $request)
    {
        $validated = $request->validate([
            'ticketType' => 'required|in:1,2,3', // Ticket type (1: 90-min, 2: 1-day, 3: Monthly)
        ]);

        $ticketPrices = [
            1 => 3,  // 90-minute ticket
            2 => 15, // 1-Day Ticket
            3 => 80, // Monthly Subscription
        ];

        $ticketType = $request->input('ticketType');
        $price = $ticketPrices[$ticketType] ?? null;

        if (is_null($price)) {
            return redirect()->route('tickets.index')->with('error', 'Invalid ticket type selected.');
        }

        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route('login')->with('error', 'You must be logged in to buy a ticket.');
        }

        if ($user->balance < $price) {
            return redirect()->route('tickets.index')->with('error', 'Insufficient funds to purchase the ticket.');
        }

        $user->balance -= $price;
        $user->save();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'ticket_purchase',
            'status' => 'completed',
        ]);

        PurchasedTicket::create([
            'user_id' => $user->id,
            'transaction_id' => $transaction->id,
            'ticket_type' => $ticketType,
            'price' => $price,
        ]);

        return redirect()->route('tickets.index')->with('status', 'Ticket purchased successfully!');
    }

    /**
     * Handle a 1-day ticket purchase.
     */
    public function buy1Day(Request $request)
    {
        $validated = $request->validate([
            'paymentMethod' => 'required|string',
        ]);

        $price = 15; // Fixed price for a 1-day ticket

        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route('login')->with('error', 'You must be logged in to purchase a 1-day ticket.');
        }

        if ($user->balance < $price) {
            return redirect()->route('tickets.index')->with('error', 'Insufficient funds to purchase the 1-day ticket.');
        }

        $user->balance -= $price;
        $user->save();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'ticket_purchase',
            'status' => 'completed',
        ]);

        PurchasedTicket::create([
            'user_id' => $user->id,
            'transaction_id' => $transaction->id,
            'ticket_type' => '1-day',
            'price' => $price,
        ]);

        return redirect()->route('tickets.index')->with('status', '1-Day Ticket purchased successfully!');
    }

    /**
     * Handle subscription purchase.
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'ticketType' => 'required|in:2,3',
        ]);

        $ticketPrices = [
            2 => 15,  // 1-Day Subscription
            3 => 80,  // Monthly Subscription
        ];

        $ticketType = $request->input('ticketType');
        $price = $ticketPrices[$ticketType] ?? null;

        if (is_null($price)) {
            return redirect()->route('tickets.index')->with('error', 'Invalid subscription type selected.');
        }

        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route('login')->with('error', 'You must be logged in to subscribe.');
        }

        if ($user->balance < $price) {
            return redirect()->route('tickets.index')->with('error', 'Insufficient funds for subscription.');
        }

        $user->balance -= $price;
        $user->save();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'subscription_purchase',
            'status' => 'completed',
        ]);

        PurchasedTicket::create([
            'user_id' => $user->id,
            'transaction_id' => $transaction->id,
            'ticket_type' => $ticketType == 2 ? '1-day' : 'monthly',
            'price' => $price,
        ]);

        return redirect()->route('tickets.index')->with('status', 'Subscription purchased successfully!');
    }

    /**
     * Add funds to the user's account.
     */
    public function addFunds(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route('login')->with('error', 'You must be logged in to add funds.');
        }

        $amount = $request->input('amount');

        $user->balance += $amount;
        $user->save();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'fund_addition',
            'status' => 'completed',
        ]);

        return redirect()->route('dashboard')->with('status', 'Funds added successfully!');
    }
}
