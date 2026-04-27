<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dealer;
use App\Services\DealerService;
use Illuminate\Support\Facades\Auth;

/**
 * DealerManagement Livewire Component
 *
 * Manages the dealer/party directory: listing, creation, and editing.
 * Dealers are business parties who book freight trips.
 *
 * Business logic is delegated to DealerService.
 * This component only handles UI state, validation, and flash messaging.
 */
class DealerManagement extends Component
{
    use WithPagination;

    // --- Search Property ---
    /** @var string Search query for filtering by company name, contact, phone, or city */
    public $search = '';

    // --- Dealer Form Properties ---
    /** @var int|null Dealer ID (set during edit mode) */
    public $dealer_id;
    /** @var string Dealer's company/business name */
    public $company_name;
    /** @var string|null Name of the primary contact person */
    public $contact_person_name;
    /** @var string|null 15-character GSTIN number */
    public $gstin;
    /** @var string|null 10-character PAN number */
    public $pan_number;
    /** @var string|null Primary phone number */
    public $phone_number;
    /** @var string|null Alternate/secondary phone number */
    public $alternate_phone;
    /** @var string|null Email address */
    public $email;
    /** @var string|null Full billing address */
    public $billing_address;
    /** @var string|null City name */
    public $city;
    /** @var string|null State name */
    public $state;
    /** @var string|null 6-digit postal/PIN code */
    public $pincode;

    /** @var bool Whether the form is in edit mode */
    public $isEditMode = false;

    /** Reset pagination when search query changes */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * "Active" field handling: Auto-uppercase and PAN extraction.
     */
    public function updatedGstin($value)
    {
        $this->gstin = strtoupper($value);
        
        // Auto-fill PAN from GSTIN (GSTIN characters 3 to 12 represent the PAN)
        if (strlen($this->gstin) >= 12) {
            $extractedPan = substr($this->gstin, 2, 10);
            // Basic check if it looks like a PAN (5 letters + 4 digits + 1 letter)
            if (preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', $extractedPan)) {
                $this->pan_number = $extractedPan;
            }
        }
    }

    public function updatedPanNumber($value)
    {
        $this->pan_number = strtoupper($value);
    }

    /**
     * Validate form inputs and save the dealer via DealerService.
     * Handles both new registration and editing of existing dealers.
     */
    public function saveDealer()
    {
        // Build validation rules with GSTIN and PAN regex patterns
        // Relaxed regex to ensure "it just works" for various GSTIN formats while maintaining 15 chars
        $uniqueGstin =  'nullable|string|size:15|regex:/^[0-9]{2}[A-Z0-9]{13}$/i|unique:dealers,gstin';
        $uniquePan = 'nullable|string|size:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i|unique:dealers,pan_number';
        $uniquePhone = 'nullable|string|max:15';
        $uniqueEmail = 'nullable|email';

        // Exclude current record from unique checks during edit
        if ($this->isEditMode) {
            $uniqueGstin .= ',' . $this->dealer_id;
            $uniquePan .= ',' . $this->dealer_id;
        }

        $this->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => $uniquePhone,
            'email' => $uniqueEmail,
            'gstin' => $uniqueGstin,
            'pan_number' => $uniquePan,
            'pincode' => 'nullable|digits:6',
        ]);

        try {
            $dealerService = app(DealerService::class);
            $dealerService->createOrUpdate([
                'company_name' => $this->company_name,
                'contact_person_name' => $this->contact_person_name,
                'gstin' => $this->gstin,
                'pan_number' => $this->pan_number,
                'phone_number' => $this->phone_number,
                'alternate_phone' => $this->alternate_phone,
                'email' => $this->email,
                'billing_address' => $this->billing_address,
                'city' => $this->city,
                'state' => $this->state,
                'pincode' => $this->pincode,
            ], Auth::id(), $this->isEditMode ? $this->dealer_id : null);

            if ($this->isEditMode) {
                session()->flash('success', 'Dealer updated successfully!');
            } else {
                session()->flash('success', 'New Dealer added successfully!');
            }

            $this->resetForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Populate the form with an existing dealer's data for editing.
     *
     * @param int $id The dealer ID to edit
     */
    public function editDealer($id)
    {
        $dealer = Dealer::where('owner_id', Auth::id())->findOrFail($id);

        $this->dealer_id = $dealer->id;
        $this->company_name = $dealer->company_name;
        $this->contact_person_name = $dealer->contact_person_name;
        $this->gstin = $dealer->gstin;
        $this->pan_number = $dealer->pan_number;
        $this->phone_number = $dealer->phone_number;
        $this->alternate_phone = $dealer->alternate_phone;
        $this->email = $dealer->email;
        $this->billing_address = $dealer->billing_address;
        $this->city = $dealer->city;
        $this->state = $dealer->state;
        $this->pincode = $dealer->pincode;

        $this->isEditMode = true;
    }

    /**
     * Reset the dealer form to its initial state.
     */
    public function resetForm()
    {
        $this->reset([
            'dealer_id', 'company_name', 'contact_person_name', 'gstin', 'pan_number',
            'phone_number', 'alternate_phone', 'email', 'billing_address',
            'city', 'state', 'pincode', 'isEditMode',
        ]);
        $this->resetValidation();
    }

    /**
     * Render the component view with paginated dealer list.
     */
    public function render()
    {
        $dealerService = app(DealerService::class);
        $dealers = $dealerService->getFilteredDealers(Auth::id(), $this->search);

        return view('livewire.admin.dealer-management', [
            'dealers' => $dealers,
        ]);
    }
}