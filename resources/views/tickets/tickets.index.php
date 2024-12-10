<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index()
    {
        // Exemplu de date pentru bilete
        $tickets = [
            ['type' => 'Bilet simplu', 'price' => 2.0],
            ['type' => 'Bilet dus-întors', 'price' => 3.5],
            ['type' => 'Bilet de zi', 'price' => 7.0],
        ];

        return view('tickets.index', compact('tickets'));
    }
}
