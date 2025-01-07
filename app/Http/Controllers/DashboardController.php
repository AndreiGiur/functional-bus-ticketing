<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

// Import the balance service

class DashboardController extends Controller
{

    /**
     * Show the user dashboard with balance and tickets.
     */
    public function getUserBalance(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {

        $user = Auth::user(); // Fetch the authenticated user
        $balance = $user->balance; // Get the user's balance from the database

        return view('dashboard', compact('balance'));
    }
}
