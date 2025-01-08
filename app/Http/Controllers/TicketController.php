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
    public function index(){
    }

    private const TICKET_TYPES = [
        ['id' => 1, 'name' => '90-min Ticket', 'price' => 3],
        ['id' => 2, 'name' => '1-Day Ticket', 'price' => 15],
        ['id' => 3, 'name' => 'Monthly Subscription', 'price' => 80],
    ];


    public function getAllTicketTypes()
    {
        // Use the globally defined ticket types
        return response()->json(self::TICKET_TYPES);
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

        // Lambda to check if the user is authenticated
        $checkAuthentication = fn() => !$user ? throw new \Exception('User not authenticated.') : null;
        $checkAuthentication();

        // Lambda to check for sufficient balance
        $checkBalance = fn() => $user->balance <= 0 ? throw new \Exception('Insufficient funds to buy a ticket.') : null;
        $checkBalance();

        // Validate request input
        $validated = $request->validate([
            'ticketType' => 'required|in:1,2,3',
        ]);

        // Define ticket prices
        $ticketPrices = [1 => 3, 2 => 15, 3 => 80];

        // Lambda to fetch ticket price
        $getTicketPrice = fn($ticketType) => $ticketPrices[$ticketType];
        $ticketType = $validated['ticketType'];
        $price = $getTicketPrice($ticketType);

        // Deduct the ticket price from the user's balance
        $deductBalance = fn() => $user->balance -= $price;
        $deductBalance();
        $user->save();

        $logMessage = fn($message, $context = []) => \Log::info($message, $context);

        $logMessage('Cumpararea tichetului a fost initializata cu succes', [
            'user_id' => $user->id,
            'ticket_type' => $ticketType,
            'price' => $price,
        ]);

        $logMessage('Creaza tichet pentru utilizator', [
            'user_id' => $user->id,
        ]);

        $createTicket = fn() => Ticket::create([
            'user_id' => $user->id,
            'type' => $ticketType,
            'price' => $price,
        ]);
        $ticket = $createTicket();

        // Create the associated transaction
        $createTransaction = fn() => Transaction::create([
            'user_id' => $user->id,
            'amount' => $price,
            'type' => 'ticket_purchase',
            'status' => 'completed',
        ]);
        $createTransaction();

        return redirect()->route('dashboard')->with('status', 'Tichet cumparat cu succes!');
    }


}
