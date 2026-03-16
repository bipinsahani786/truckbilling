<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

/**
 * VehicleManagement Livewire Component
 *
 * Manages the vehicle fleet: listing, registration, editing, and document uploads.
 * Handles file uploads for RC, insurance, fitness documents, and truck photos.
 *
 * Business logic is delegated to VehicleService.
 * This component only handles UI state, validation, and flash messaging.
 */
class VehicleManagement extends Component
{
    use WithPagination, WithFileUploads;

    #[Layout('layouts.app')]

    // --- Search & Filter Properties ---
    /** @var string Search query for filtering by truck number or RC number */
    public $search = '';
    /** @var string Filter by vehicle status: 'active', 'maintenance', or 'inactive' */
    public $statusFilter = '';

    // --- Vehicle Form Properties ---
    /** @var int|null Vehicle ID (set during edit mode) */
    public $vehicle_id;
    /** @var string Vehicle registration/number plate */
    public $truck_number;
    /** @var string Type of truck (e.g., Open Body, Container) */
    public $truck_type;
    /** @var string|null Load capacity in metric tons */
    public $capacity_tons;
    /** @var string|null Registration Certificate number */
    public $rc_number;
    /** @var string|null Chassis number */
    public $chassis_number;
    /** @var string|null Engine number */
    public $engine_number;
    /** @var string|null Insurance policy expiry date */
    public $insurance_expiry_date;
    /** @var string|null Fitness certificate expiry date */
    public $fitness_expiry_date;
    /** @var string|null National permit expiry date */
    public $national_permit_expiry_date;
    /** @var string|null PUC certificate expiry date */
    public $pollution_expiry_date;
    /** @var string Vehicle availability status */
    public $status = 'active';

    // --- File Upload Properties (new uploads from the form) ---
    /** @var \Livewire\TemporaryUploadedFile|null New RC document file */
    public $rc_document;
    /** @var \Livewire\TemporaryUploadedFile|null New insurance document file */
    public $insurance_document;
    /** @var \Livewire\TemporaryUploadedFile|null New fitness document file */
    public $fitness_document;
    /** @var \Livewire\TemporaryUploadedFile|null New truck photo file */
    public $truck_photo;

    // --- Existing File Paths (shown in edit mode for preview) ---
    /** @var string|null Path to existing RC document on disk */
    public $existing_rc_document;
    /** @var string|null Path to existing insurance document on disk */
    public $existing_insurance_document;
    /** @var string|null Path to existing fitness document on disk */
    public $existing_fitness_document;
    /** @var string|null Path to existing truck photo on disk */
    public $existing_truck_photo;

    /** @var bool Whether the form is in edit mode */
    public $isEditMode = false;

    /** Reset pagination when search query changes */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Validate form inputs and save the vehicle via VehicleService.
     * Handles both new registration and editing of existing vehicles.
     */
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

        // Prepare file uploads array (only include files that were actually uploaded)
        $files = [];
        if ($this->rc_document) $files['rc_document'] = $this->rc_document;
        if ($this->insurance_document) $files['insurance_document'] = $this->insurance_document;
        if ($this->fitness_document) $files['fitness_document'] = $this->fitness_document;
        if ($this->truck_photo) $files['truck_photo'] = $this->truck_photo;

        $vehicleService = app(VehicleService::class);
        $vehicleService->createOrUpdate([
            'truck_number' => $this->truck_number,
            'truck_type' => $this->truck_type,
            'capacity_tons' => $this->capacity_tons,
            'rc_number' => $this->rc_number,
            'chassis_number' => $this->chassis_number,
            'engine_number' => $this->engine_number,
            'insurance_expiry_date' => $this->insurance_expiry_date,
            'fitness_expiry_date' => $this->fitness_expiry_date,
            'national_permit_expiry_date' => $this->national_permit_expiry_date,
            'pollution_expiry_date' => $this->pollution_expiry_date,
            'status' => $this->status,
        ], $files ?: null, Auth::id(), $this->isEditMode ? $this->vehicle_id : null);

        if ($this->isEditMode) {
            session()->flash('success', 'Vehicle Data & Documents Updated!');
        } else {
            session()->flash('success', 'New Vehicle Registered Successfully!');
        }

        $this->resetForm();
    }

    /**
     * Populate the form with an existing vehicle's data for editing.
     *
     * @param int $id The vehicle ID to edit
     */
    public function editVehicle($id)
    {
        $vehicle = Vehicle::where('owner_id', Auth::id())->findOrFail($id);

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

        // Store existing file paths for preview/view buttons in the UI
        $this->existing_rc_document = $vehicle->rc_document_path;
        $this->existing_insurance_document = $vehicle->insurance_document_path;
        $this->existing_fitness_document = $vehicle->fitness_document_path;
        $this->existing_truck_photo = $vehicle->truck_photo_path;

        $this->isEditMode = true;
    }

    /**
     * Reset the vehicle form to its initial state.
     */
    public function resetForm()
    {
        $this->reset([
            'vehicle_id', 'truck_number', 'truck_type', 'capacity_tons',
            'rc_number', 'chassis_number', 'engine_number',
            'insurance_expiry_date', 'fitness_expiry_date', 'national_permit_expiry_date', 'pollution_expiry_date',
            'status', 'rc_document', 'insurance_document', 'fitness_document', 'truck_photo',
            'existing_rc_document', 'existing_insurance_document', 'existing_fitness_document', 'existing_truck_photo',
            'isEditMode',
        ]);
        $this->status = 'active';
        $this->resetValidation();
    }

    /**
     * Render the component view with paginated vehicle list and fleet statistics.
     */
    public function render()
    {
        $vehicleService = app(VehicleService::class);

        $vehicles = $vehicleService->getFilteredVehicles(Auth::id(), $this->search, $this->statusFilter);
        $stats = $vehicleService->getStats(Auth::id());

        return view('livewire.admin.vehicle-management', [
            'vehicles' => $vehicles,
            'activeCount' => $stats['activeCount'],
            'totalCount' => $stats['totalCount'],
        ]);
    }
}