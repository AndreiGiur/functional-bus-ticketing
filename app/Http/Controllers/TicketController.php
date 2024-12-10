<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = [
            ['type' => 'Regular Ticket', 'price' => 3.00],
            ['type' => '1-Day Ticket', 'price' => 15.00],
            ['type' => 'Abonament lunar', 'price' => 200.00],
        ];

        return view('tickets.index', compact('tickets'));
    }

    public function buy()
    {
        return view('tickets.buy');
    }

    public function buy1Day(Request $request)
    {
        $validated = $request->validate([
            'ticketQuantity' => 'required|integer|min:1',
            'paymentMethod' => 'required|string',
        ]);

        return redirect()->route('tickets.index')->with('status', '1-Day Ticket Purchased!');
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'paymentMethod' => 'required|string',
        ]);

        return redirect()->route('tickets.index')->with('status', 'Subscription Purchased!');
    }
}
