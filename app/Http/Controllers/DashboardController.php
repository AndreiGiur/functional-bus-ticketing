<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with balance and purchased tickets.
     */
    public function getUserBalance()
    {
        $user = Auth::user(); // Fetch the authenticated user
        $balance = $user->balance; // Get the user's balance from the database

        // Define the ticket types globally in the class
        $ticketTypes = collect([
            ['id' => 1, 'name' => '90-min Ticket', 'price' => 3],
            ['id' => 2, 'name' => '1-Day Ticket', 'price' => 15],
            ['id' => 3, 'name' => 'Monthly Subscription', 'price' => 80],
        ]);

        // Fetch purchased tickets for the user
        $purchasedTickets = Ticket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Order by the purchase date in descending order
            ->get()
            ->map(function ($ticket) use ($ticketTypes) {
                // Find the ticket type details
                $ticketType = $ticketTypes->firstWhere('id', $ticket->type);

                // Add the ticket name dynamically
                $ticket->type_name = $ticketType['name'] ?? 'Unknown Ticket';

                return $ticket;
            });

        return view('dashboard', compact('balance', 'purchasedTickets'));
    }

}
