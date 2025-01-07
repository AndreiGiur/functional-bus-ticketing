<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    /**
     * Add a specified amount to the user's balance.
     *
     * @param float $amount
     * @return float
     * @throws \Exception
     */
    public function addBalance(float $amount): float
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('User not authenticated.');
        }

        if ($amount <= 0) {
            throw new \Exception('The amount to be added must be greater than zero.');
        }

        DB::beginTransaction();

        try {

            \Log::info('Adding funds for user ID: ' . Auth::id());
            \Log::info('Amount: ' . $amount);

            $user->balance += $amount;
            $user->save();

            DB::commit();

            return $user->balance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Handle the addition of funds via a form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFunds(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            // Add funds to the user's balance
            $this->addBalance($validated['amount']);

            // Record the transaction
            Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $validated['amount'],
                'type' => 'fund_addition',
                'status' => 'completed',
            ]);

            return redirect()->route('dashboard')->with('status', 'Fonduri adăugate cu succes!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
