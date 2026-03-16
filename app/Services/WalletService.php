<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

/**
 * WalletService
 *
 * Handles all wallet-related business logic including wallet creation,
 * fund management, status toggling, and transaction recording.
 * This service is used by both the Livewire components and can be
 * reused by API controllers in the future.
 */
class WalletService
{
    /**
     * Create a new wallet for a driver.
     * Called automatically when a new driver is registered.
     *
     * @param int $ownerId  The fleet owner's user ID
     * @param int $driverId The driver's user ID
     * @return Wallet The newly created wallet instance
     */
    public function createWallet(int $ownerId, int $driverId): Wallet
    {
        return Wallet::create([
            'owner_id' => $ownerId,
            'driver_id' => $driverId,
            'balance' => 0.00,
            'status' => 'active',
        ]);
    }

    /**
     * Add funds (credit) to a driver's wallet.
     * Uses database locking to prevent race conditions on balance updates.
     *
     * @param int    $walletId The wallet to credit
     * @param float  $amount   Amount to add (must be > 0)
     * @param string $remarks  Description/reason for adding funds
     * @return void
     */
    public function addFunds(int $walletId, float $amount, string $remarks): void
    {
        DB::transaction(function () use ($walletId, $amount, $remarks) {
            // Lock the wallet row to prevent concurrent balance modifications
            $wallet = Wallet::lockForUpdate()->findOrFail($walletId);

            // Update the wallet balance
            $wallet->balance += $amount;
            $wallet->save();

            // Record the credit transaction for audit trail
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'description' => $remarks,
            ]);
        });
    }

    /**
     * Toggle a wallet's status between 'active' and 'frozen'.
     * A frozen wallet cannot be used for trip expenses.
     *
     * @param int $walletId The wallet to toggle
     * @return Wallet The updated wallet instance
     */
    public function toggleStatus(int $walletId): Wallet
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->status = $wallet->status === 'active' ? 'frozen' : 'active';
        $wallet->save();

        return $wallet;
    }

    /**
     * Get the current balance of a driver's wallet.
     *
     * @param int $driverId The driver's user ID
     * @return float Current wallet balance (0 if no wallet exists)
     */
    public function getBalance(int $driverId): float
    {
        $wallet = Wallet::where('driver_id', $driverId)->first();
        return $wallet ? $wallet->balance : 0;
    }

    /**
     * Apply wallet impact when a trip transaction is created.
     * - Expense transactions DEBIT the wallet (reduce balance)
     * - Recovery transactions CREDIT the wallet (increase balance)
     *
     * Only applies when payment_mode is 'wallet'.
     *
     * @param string $paymentMode     The payment method used
     * @param string $transactionType Either 'expense' or 'recovery'
     * @param float  $amount          The transaction amount
     * @param int    $driverId        The driver whose wallet is affected
     * @param int    $tripId          The trip ID for the transaction description
     * @return void
     */
    public function applyTripImpact(string $paymentMode, string $transactionType, float $amount, int $driverId, int $tripId): void
    {
        if ($paymentMode !== 'wallet') {
            return;
        }

        $wallet = Wallet::where('driver_id', $driverId)->lockForUpdate()->first();
        if (!$wallet) {
            return;
        }

        if ($transactionType === 'expense') {
            // Expense: Deduct from wallet balance
            $wallet->balance -= $amount;
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'description' => 'Trip Exp T-' . $tripId,
            ]);
        } else {
            // Recovery: Add to wallet balance
            $wallet->balance += $amount;
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'description' => 'Trip Rec T-' . $tripId,
            ]);
        }

        $wallet->save();
    }

    /**
     * Reverse the wallet impact of a trip transaction.
     * Used when editing or deleting a transaction to undo its effect.
     *
     * @param string $paymentMode     The payment method used
     * @param string $transactionType Either 'expense' or 'recovery'
     * @param float  $amount          The transaction amount to reverse
     * @param int    $driverId        The driver whose wallet is affected
     * @param int    $tripId          The trip ID for the transaction description
     * @return void
     */
    public function reverseTripImpact(string $paymentMode, string $transactionType, float $amount, int $driverId, int $tripId): void
    {
        if ($paymentMode !== 'wallet') {
            return;
        }

        $wallet = Wallet::where('driver_id', $driverId)->lockForUpdate()->first();
        if (!$wallet) {
            return;
        }

        if ($transactionType === 'expense') {
            // Reverse expense: Credit back to wallet
            $wallet->balance += $amount;
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'description' => 'Reversed Exp T-' . $tripId,
            ]);
        } else {
            // Reverse recovery: Debit from wallet
            $wallet->balance -= $amount;
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'description' => 'Reversed Rec T-' . $tripId,
            ]);
        }

        $wallet->save();
    }

    /**
     * Get the full transaction history for a wallet, newest first.
     *
     * @param int $walletId The wallet to fetch history for
     * @return Collection Collection of WalletTransaction records
     */
    public function getTransactionHistory(int $walletId): Collection
    {
        return WalletTransaction::where('wallet_id', $walletId)
            ->latest()
            ->get();
    }
}
