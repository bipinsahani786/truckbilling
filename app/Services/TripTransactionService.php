<?php

namespace App\Services;

use App\Models\TripTransaction;
use Illuminate\Support\Facades\DB;

/**
 * TripTransactionService
 *
 * Handles trip transaction CRUD operations. Each transaction represents
 * either an expense or recovery against a trip. When transactions use
 * the 'wallet' payment mode, the WalletService is called to update
 * the driver's wallet balance accordingly.
 */
class TripTransactionService
{
    /**
     * @var WalletService Injected wallet service for wallet balance updates
     */
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Create a new transaction or update an existing one.
     *
     * When updating, the old wallet impact is first reversed before
     * applying the new values, ensuring the wallet balance stays accurate.
     *
     * @param array    $data     Transaction attributes (trip_id, transaction_type, payment_mode, amount, etc.)
     * @param int|null $txId     If provided, updates the existing transaction; otherwise creates new
     * @param int      $driverId The driver's user ID (needed for wallet operations)
     * @param int      $tripId   The trip's ID (needed for wallet transaction descriptions)
     * @return TripTransaction The created or updated transaction instance
     */
    public function createOrUpdate(array $data, ?int $txId, int $driverId, int $tripId): TripTransaction
    {
        $tx = null;

        DB::transaction(function () use ($data, $txId, $driverId, $tripId, &$tx) {
            if ($txId) {
                // Update mode: first reverse the old wallet impact, then apply new values
                $tx = TripTransaction::findOrFail($txId);

                // Reverse the wallet effect of the original transaction
                $this->walletService->reverseTripImpact(
                    $tx->payment_mode,
                    $tx->transaction_type,
                    $tx->amount,
                    $driverId,
                    $tripId
                );

                // Update the transaction record with new values
                $tx->update([
                    'expense_category_id' => ($data['expense_category_id'] ?? '') === '' ? null : $data['expense_category_id'],
                    'amount' => $data['amount'],
                    'remarks' => $data['remarks'] ?? null,
                ]);

                // Apply the wallet effect with the updated values
                $this->walletService->applyTripImpact(
                    $tx->payment_mode,
                    $tx->transaction_type,
                    $data['amount'],
                    $driverId,
                    $tripId
                );
            } else {
                // Create mode: create the transaction and apply wallet impact
                $tx = TripTransaction::create([
                    'trip_id' => $data['trip_id'],
                    'added_by' => $data['added_by'],
                    'transaction_type' => $data['transaction_type'],
                    'expense_category_id' => ($data['expense_category_id'] ?? '') === '' ? null : $data['expense_category_id'],
                    'amount' => $data['amount'],
                    'payment_mode' => $data['payment_mode'],
                    'remarks' => $data['remarks'] ?? null,
                ]);

                // Apply the wallet effect for the new transaction
                $this->walletService->applyTripImpact(
                    $tx->payment_mode,
                    $tx->transaction_type,
                    $tx->amount,
                    $driverId,
                    $tripId
                );
            }
        });

        return $tx;
    }

    /**
     * Delete a transaction and reverse its wallet impact.
     *
     * @param int $txId     The transaction ID to delete
     * @param int $driverId The driver's user ID (for wallet reversal)
     * @param int $tripId   The trip's ID (for wallet transaction description)
     * @return void
     */
    public function delete(int $txId, int $driverId, int $tripId): void
    {
        DB::transaction(function () use ($txId, $driverId, $tripId) {
            $tx = TripTransaction::findOrFail($txId);

            // Reverse the wallet impact before deleting
            $this->walletService->reverseTripImpact(
                $tx->payment_mode,
                $tx->transaction_type,
                $tx->amount,
                $driverId,
                $tripId
            );

            $tx->delete();
        });
    }
}
