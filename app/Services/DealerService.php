<?php

namespace App\Services;

use App\Models\Dealer;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * DealerService
 *
 * Handles all dealer/party-related business logic including
 * creating, updating, and listing dealers with search filtering.
 */
class DealerService
{
    /**
     * Create a new dealer or update an existing one.
     *
     * GSTIN and PAN numbers are automatically converted to uppercase.
     * The owner_id is automatically set by the BelongsToOwner trait
     * during creation, so it doesn't need to be explicitly provided.
     *
     * @param array    $data     Dealer attributes (company_name, gstin, phone_number, etc.)
     * @param int      $ownerId  The fleet owner's user ID
     * @param int|null $dealerId If provided, updates the existing dealer; otherwise creates a new one
     * @return Dealer The created or updated dealer instance
     */
    public function createOrUpdate(array $data, int $ownerId, ?int $dealerId = null): Dealer
    {
        // Prepare data with uppercase formatting for tax identifiers
        $dealerData = [
            'company_name' => $data['company_name'],
            'contact_person_name' => $data['contact_person_name'] ?? null,
            'gstin' => strtoupper($data['gstin'] ?? ''),
            'pan_number' => strtoupper($data['pan_number'] ?? ''),
            'phone_number' => $data['phone_number'] ?? null,
            'alternate_phone' => $data['alternate_phone'] ?? null,
            'email' => $data['email'] ?? null,
            'billing_address' => $data['billing_address'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'pincode' => $data['pincode'] ?? null,
        ];

        if ($dealerId) {
            // Update: ensure the dealer belongs to the authenticated owner
            $dealer = Dealer::where('owner_id', $ownerId)->findOrFail($dealerId);
            $dealer->update($dealerData);
            return $dealer;
        }

        // Create: owner_id is auto-injected by the BelongsToOwner trait
        return Dealer::create($dealerData);
    }

    /**
     * Get a filtered and paginated list of dealers for an owner.
     *
     * @param int         $ownerId The fleet owner's user ID
     * @param string|null $search  Search term to filter by company name, contact person, phone, or city
     * @return LengthAwarePaginator Paginated dealer results
     */
    public function getFilteredDealers(int $ownerId, ?string $search = null): LengthAwarePaginator
    {
        $query = Dealer::where('owner_id', $ownerId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('contact_person_name', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }
}
