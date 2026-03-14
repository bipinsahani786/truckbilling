<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <--- File delete karne ke liye
use Livewire\Attributes\Layout;

class VehicleManagement extends Component
{
    use WithPagination, WithFileUploads;

    #[Layout('layouts.app')]

    public $search = '';
    public $statusFilter = '';

    // --- FORM FIELDS ---
    public $vehicle_id;
    public $truck_number, $truck_type, $capacity_tons;
    public $rc_number, $chassis_number, $engine_number;
    public $insurance_expiry_date, $fitness_expiry_date, $national_permit_expiry_date, $pollution_expiry_date;
    public $status = 'active';

    // --- FILE UPLOADS (New Files) ---
    public $rc_document, $insurance_document, $fitness_document, $truck_photo;
    
    // --- EXISTING FILES (To show in Edit Mode) ---
    public $existing_rc_document, $existing_insurance_document, $existing_fitness_document, $existing_truck_photo;
    
    public $isEditMode = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function saveVehicle()
    {
        $rules = [
            'truck_number' => 'required|string|unique:vehicles,truck_number,' . $this->vehicle_id,
            'truck_type' => 'required|string',
            'capacity_tons' => 'nullable|numeric',
            'rc_number' => 'nullable|string|unique:vehicles,rc_number,' . $this->vehicle_id,
            'chassis_number' => 'nullable|string',
            'engine_number' => 'nullable|string',
            'insurance_expiry_date' => 'nullable|date',
            'fitness_expiry_date' => 'nullable|date',
            'national_permit_expiry_date' => 'nullable|date',
            'pollution_expiry_date' => 'nullable|date',
            'status' => 'required|in:active,maintenance,inactive',
            'rc_document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'insurance_document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'fitness_document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'truck_photo' => 'nullable|image|max:2048',
        ];

        $this->validate($rules);

        $data = [
            'owner_id' => Auth::id(),
            'truck_number' => strtoupper($this->truck_number),
            'truck_type' => $this->truck_type,
            'capacity_tons' => $this->capacity_tons,
            'rc_number' => strtoupper($this->rc_number),
            'chassis_number' => strtoupper($this->chassis_number),
            'engine_number' => strtoupper($this->engine_number),
            'insurance_expiry_date' => $this->insurance_expiry_date,
            'fitness_expiry_date' => $this->fitness_expiry_date,
            'national_permit_expiry_date' => $this->national_permit_expiry_date,
            'pollution_expiry_date' => $this->pollution_expiry_date,
            'status' => $this->status,
        ];

        // --- FILE UPLOAD & DELETE OLD FILE LOGIC ---
        
        // 1. RC Document
        if ($this->rc_document) {
            if ($this->isEditMode && $this->existing_rc_document) {
                Storage::disk('public')->delete($this->existing_rc_document); // Purani delete
            }
            $data['rc_document_path'] = $this->rc_document->store('documents/rc', 'public'); // Nayi save
        }

        // 2. Insurance Document
        if ($this->insurance_document) {
            if ($this->isEditMode && $this->existing_insurance_document) {
                Storage::disk('public')->delete($this->existing_insurance_document);
            }
            $data['insurance_document_path'] = $this->insurance_document->store('documents/insurance', 'public');
        }

        // 3. Fitness Document
        if ($this->fitness_document) {
            if ($this->isEditMode && $this->existing_fitness_document) {
                Storage::disk('public')->delete($this->existing_fitness_document);
            }
            $data['fitness_document_path'] = $this->fitness_document->store('documents/fitness', 'public');
        }

        // 4. Truck Photo
        if ($this->truck_photo) {
            if ($this->isEditMode && $this->existing_truck_photo) {
                Storage::disk('public')->delete($this->existing_truck_photo);
            }
            $data['truck_photo_path'] = $this->truck_photo->store('vehicles/photos', 'public');
        }

        // --- DATABASE SAVE ---
        if ($this->isEditMode) {
            Vehicle::where('id', $this->vehicle_id)->update($data);
            session()->flash('success', 'Vehicle Data & Documents Updated!');
        } else {
            Vehicle::create($data);
            session()->flash('success', 'New Vehicle Registered Successfully!');
        }

        $this->resetForm();
    }

    public function editVehicle($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        $this->vehicle_id = $vehicle->id;
        $this->truck_number = $vehicle->truck_number;
        $this->truck_type = $vehicle->truck_type;
        $this->capacity_tons = $vehicle->capacity_tons;
        $this->rc_number = $vehicle->rc_number;
        $this->chassis_number = $vehicle->chassis_number;
        $this->engine_number = $vehicle->engine_number;
        $this->insurance_expiry_date = $vehicle->insurance_expiry_date;
        $this->fitness_expiry_date = $vehicle->fitness_expiry_date;
        $this->national_permit_expiry_date = $vehicle->national_permit_expiry_date;
        $this->pollution_expiry_date = $vehicle->pollution_expiry_date;
        $this->status = $vehicle->status;
        
        // Load existing document paths for View button
        $this->existing_rc_document = $vehicle->rc_document_path;
        $this->existing_insurance_document = $vehicle->insurance_document_path;
        $this->existing_fitness_document = $vehicle->fitness_document_path;
        $this->existing_truck_photo = $vehicle->truck_photo_path;
        
        $this->isEditMode = true;
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        $query = Vehicle::where('owner_id', Auth::id());

        if (!empty($this->search)) {
            $query->where('truck_number', 'like', '%' . $this->search . '%')
                  ->orWhere('rc_number', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $vehicles = $query->latest()->paginate(10);
        
        $activeCount = Vehicle::where('owner_id', Auth::id())->where('status', 'active')->count();
        $totalCount = Vehicle::where('owner_id', Auth::id())->count();

        return view('livewire.admin.vehicle-management', [
            'vehicles' => $vehicles,
            'activeCount' => $activeCount,
            'totalCount' => $totalCount,
        ]);
    }
}