<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class balance
{
    /**
     * Get the balance of the currently logged-in user dynamically from the balances table.
     *
     * @return float
     */
    public function getUserBalance(): float
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        if (!$userId) {
            return 0.0; // Default to 0 if no user is authenticated
        }

        // Fetch the balance dynamically from the balances table to ensure up-to-date value
        $balance = DB::table('balances')->where('user_id', $userId)->value('balance');

        return $balance ?? 0.0; // Return 0 if balance is null
    }

    /**
     * Add a specified amount to the user's balance and update it in the balances table.
     *
     * @param float $amount
     * @return float
     */
    public function addBalance(float $amount): float
    {
        $userId = Auth::id();

        if (!$userId) {
            return 0.0; // No user authenticated
        }

        // Check if the user already has a balance row in the balances table
        $exists = DB::table('balances')->where('user_id', $userId)->exists();

        if ($exists) {
            // Add to the balance in the balances table
            DB::table('balances')
                ->where('user_id', $userId)
                ->increment('balance', $amount);
        } else {
            // Create a new balance row if it doesn't exist
            DB::table('balances')->insert([
                'user_id' => $userId,
                'balance' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Fetch the updated balance and return it
        return $this->getUserBalance();
    }

    /**
     * Deduct a specified amount from the user's balance and update it in the balances table.
     *
     * @param float $amount
     * @return float
     * @throws \Exception
     */
    public function deductBalance(float $amount): float
    {
        $userId = Auth::id();

        if (!$userId) {
            throw new \Exception('User not authenticated.');
        }

        // Dynamically fetch balance from the balances table
        $balance = $this->getUserBalance();

        // Check if there is enough balance before deducting
        if ($balance < $amount) {
            throw new \Exception('Insufficient balance.');
        }

        // Deduct the amount in the balances table
        DB::table('balances')
            ->where('user_id', $userId)
            ->decrement('balance', $amount);

        // Fetch the updated balance and return it
        return $this->getUserBalance();
    }
}
