<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Http\Controllers\BalanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TicketController extends Controller
{
    public function index()
    {
          }

    public function getUserTickets(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        // Fetch the authenticated user
        $user = Auth::user();

        // Fetch tickets linked to the user via transactions
        $userTickets = Transaction::where('user_id', $user->id)
            ->where('type', 'ticket_purchase') // Ensure it's a ticket purchase transaction
            ->with('ticket') // Eager load related tickets
            ->latest() // Order by most recent transactions
            ->get();

        // Return the view with the fetched tickets
        return view('dashboard', compact('userTickets'));
    }



    public function buyTicket(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('User not authenticated.');
        }

        if ($user->balance <= 0) {
            throw new \Exception('Insufficient funds to buy a ticket.');
        }

        $validated = $request->validate([
            'ticketType' => 'required|in:1,2,3',
        ]);

        $ticketPrices = [1 => 3, 2 => 15, 3 => 80];
        $ticketType = $validated['ticketType'];
        $price = $ticketPrices[$ticketType];

        // Deduct the ticket price from the user's balance
        $user->balance -= $price;
        $user->save();

        // Log the ticket purchase
        \Log::info('Ticket purchase processed', [
            'user_id' => $user->id,
            'ticket_type' => $ticketType,
            'price' => $price,
        ]);

        // Create a new ticket for the user
        $ticket = Ticket::create([
            'user_id' => $user->id, // Explicitly set the user_id
            'type' => $ticketType,
            'price' => $price,
        ]);

        // Create the associated transaction
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'ticket_purchase',
            'status' => 'completed',
        ]);

        return redirect()->route('tickets.index')->with('status', 'Ticket purchased successfully!');
    }

}
