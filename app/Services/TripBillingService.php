<?php

namespace App\Services;

use App\Models\TripBilling;
use Illuminate\Support\Collection;

/**
 * TripBillingService
 *
 * Handles party billing CRUD operations for trips.
 * A single trip can have multiple billing entries (multi-party billing),
 * each tracking a different party's freight and payment.
 */
class TripBillingService
{
    /**
     * Create a new billing entry or update an existing one for a trip.
     *
     * @param int      $tripId    The trip to attach the billing to
     * @param array    $data      Billing attributes (party_name, material_description, weight_tons, freight_amount, received_amount)
     * @param int|null $billingId If provided, updates the existing billing; otherwise creates new
     * @return TripBilling The created or updated billing instance
     */
    public function createOrUpdate(int $tripId, array $data, ?int $billingId = null): TripBilling
    {
        $billingData = [
            'party_name' => $data['party_name'] ?? null,
            'material_description' => $data['material_description'] ?? null,
            'weight_tons' => $data['weight_tons'] ?? null,
            'freight_amount' => $data['freight_amount'],
            'received_amount' => $data['received_amount'] ?? 0,
        ];

        if ($billingId) {
            $billing = TripBilling::findOrFail($billingId);
            $billing->update($billingData);
            return $billing;
        }

        $billingData['trip_id'] = $tripId;
        return TripBilling::create($billingData);
    }

    /**
     * Delete a billing entry.
     *
     * @param int $billingId The billing entry ID to delete
     * @return void
     */
    public function delete(int $billingId): void
    {
        TripBilling::findOrFail($billingId)->delete();
    }

    /**
     * Get all billing entries for a specific trip.
     *
     * @param int $tripId The trip ID to fetch billings for
     * @return Collection Collection of TripBilling records
     */
    public function getByTripId(int $tripId): Collection
    {
        return TripBilling::where('trip_id', $tripId)->get();
    }
}