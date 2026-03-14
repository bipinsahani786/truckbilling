<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dealer;
use Illuminate\Support\Facades\Auth;

class DealerManagement extends Component
{
    use WithPagination;

    public $search = '';
    
    // Form Inputs
    public $dealer_id;
    public $company_name, $contact_person_name;
    public $gstin, $pan_number;
    public $phone_number, $alternate_phone, $email;
    public $billing_address, $city, $state, $pincode;
    
    public $isEditMode = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function saveDealer()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'gstin' => 'nullable|string|max:15',
            'pan_number' => 'nullable|string|max:10',
        ]);

        $data = [
            'owner_id' => Auth::id(),
            'company_name' => $this->company_name,
            'contact_person_name' => $this->contact_person_name,
            'gstin' => strtoupper($this->gstin),
            'pan_number' => strtoupper($this->pan_number),
            'phone_number' => $this->phone_number,
            'alternate_phone' => $this->alternate_phone,
            'email' => $this->email,
            'billing_address' => $this->billing_address,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
        ];

        if ($this->isEditMode) {
            Dealer::where('owner_id', Auth::id())->findOrFail($this->dealer_id)->update($data);
            session()->flash('success', 'Dealer updated successfully!');
        } else {
            Dealer::create($data);
            session()->flash('success', 'New Dealer added successfully!');
        }

        $this->resetForm();
    }

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

    public function resetForm()
    {
        $this->reset([
            'dealer_id', 'company_name', 'contact_person_name', 'gstin', 'pan_number',
            'phone_number', 'alternate_phone', 'email', 'billing_address', 
            'city', 'state', 'pincode', 'isEditMode'
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        $query = Dealer::where('owner_id', Auth::id());

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('company_name', 'like', '%' . $this->search . '%')
                  ->orWhere('contact_person_name', 'like', '%' . $this->search . '%')
                  ->orWhere('phone_number', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        $dealers = $query->latest()->paginate(10);

        return view('livewire.admin.dealer-management', [
            'dealers' => $dealers
        ]);
    }
}