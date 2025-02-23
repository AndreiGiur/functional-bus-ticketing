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

        $checkAuthenticated = fn() => !$user ? throw new \Exception('User not authenticated.') : null;
        $checkAuthenticated();

        $validateAmount = fn() => $amount <= 0 ? throw new \Exception('The amount to be added must be greater than zero.') : null;
        $validateAmount();

        $handleTransaction = function () use ($user, $amount) {
            DB::beginTransaction();
            try {
                $user->balance += $amount;
                $user->save();

                DB::commit();
                return $user->balance;
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        };

        return $handleTransaction();
    }

    /**
     * Handle the addition of funds via a form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFunds(Request $request)
    {
        // Lambda for validating the request
        $validateRequest = fn($req) => $req->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $validated = $validateRequest($request);

        // Lambda for creating a transaction record
        $createTransaction = fn($userId, $amount) => Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
            'type' => 'fund_addition',
            'status' => 'completed',
        ]);

        try {
            $newBalance = $this->addBalance($validated['amount']);

            $createTransaction(Auth::id(), $validated['amount']);

            return redirect()->route('dashboard')->with('status', 'Fonduri adăugate cu succes!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
