<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Buy a ticket using the Lambda function
     */
    public function buy(Request $request)
    {
        // Validate the ticket type input
        $validated = $request->validate([
            'ticketType' => 'required|in:1,2,3', // Allowable ticket types
        ]);

        try {
            // Call the Lambda function via API Gateway
            $response = Http::post('http://127.0.0.1:8000/tickets/buy', [
                'ticketType' => $validated['ticketType'],
                'userId' => Auth::id(), // Ensure the authenticated user ID is passed
            ]);

            // Check if the request to Lambda failed
            if ($response->failed()) {
                return redirect()
                    ->route('tickets.index')
                    ->with('status', 'Failed to buy ticket. Please try again.');
            }

            // Success response
            return redirect()
                ->route('tickets.index')
                ->with('status', 'Ticket purchased successfully!');
        } catch (\Exception $e) {
            // Catch and log any exceptions
            \Log::error('Error buying ticket: ' . $e->getMessage());

            return redirect()
                ->route('tickets.index')
                ->with('status', 'An unexpected error occurred. Please try again later.');
        }
    }
}
