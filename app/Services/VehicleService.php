<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * VehicleService
 *
 * Handles all vehicle-related business logic including registration,
 * updates, document file uploads with old file cleanup, and fleet statistics.
 */
class VehicleService
{
    /**
     * Create a new vehicle or update an existing one.
     *
     * Handles file uploads for RC document, insurance document, fitness document,
     * and truck photo. When updating, old files are automatically deleted from
     * storage before saving the new ones.
     *
     * @param array      $data      Vehicle attributes (truck_number, truck_type, etc.)
     * @param array|null $files     Associative array of uploaded files: ['rc_document' => UploadedFile, ...]
     * @param int        $ownerId   The fleet owner's user ID
     * @param int|null   $vehicleId If provided, updates the existing vehicle; otherwise creates a new one
     * @return Vehicle The created or updated vehicle instance
     */
    public function createOrUpdate(array $data, ?array $files, int $ownerId, ?int $vehicleId = null): Vehicle
    {
        // Prepare the base data array with uppercase formatting for identifiers
        $vehicleData = [
            'owner_id' => $ownerId,
            'truck_number' => strtoupper($data['truck_number']),
            'truck_type' => $data['truck_type'],
            'capacity_tons' => $data['capacity_tons'] ?? null,
            'rc_number' => strtoupper($data['rc_number'] ?? ''),
            'chassis_number' => strtoupper($data['chassis_number'] ?? ''),
            'engine_number' => strtoupper($data['engine_number'] ?? ''),
            'insurance_expiry_date' => $data['insurance_expiry_date'] ?? null,
            'fitness_expiry_date' => $data['fitness_expiry_date'] ?? null,
            'national_permit_expiry_date' => $data['national_permit_expiry_date'] ?? null,
            'pollution_expiry_date' => $data['pollution_expiry_date'] ?? null,
            'status' => $data['status'] ?? 'active',
        ];

        // Load existing vehicle for update mode (to get current file paths)
        $existingVehicle = $vehicleId
            ? Vehicle::where('owner_id', $ownerId)->findOrFail($vehicleId)
            : null;

        // Process each document upload: store new file, delete old one if replacing
        $fileMapping = [
            'rc_document' => ['path_column' => 'rc_document_path', 'storage_folder' => 'documents/rc'],
            'insurance_document' => ['path_column' => 'insurance_document_path', 'storage_folder' => 'documents/insurance'],
            'fitness_document' => ['path_column' => 'fitness_document_path', 'storage_folder' => 'documents/fitness'],
            'truck_photo' => ['path_column' => 'truck_photo_path', 'storage_folder' => 'vehicles/photos'],
        ];

        foreach ($fileMapping as $fileKey => $config) {
            if (!empty($files[$fileKey])) {
                // Delete the old file from storage if we're updating and an old file exists
                if ($existingVehicle && $existingVehicle->{$config['path_column']}) {
                    Storage::disk('public')->delete($existingVehicle->{$config['path_column']});
                }
                // Store the new file and record its path
                $vehicleData[$config['path_column']] = $files[$fileKey]->store($config['storage_folder'], 'public');
            }
        }

        // Create new vehicle or update existing one
        if ($existingVehicle) {
            $existingVehicle->update($vehicleData);
            return $existingVehicle;
        }

        return Vehicle::create($vehicleData);
    }

    /**
     * Get a filtered and paginated list of vehicles for an owner.
     *
     * @param int         $ownerId The fleet owner's user ID
     * @param string|null $search  Search term to filter by truck_number or rc_number
     * @param string|null $status  Vehicle status filter: 'active', 'maintenance', or 'inactive'
     * @return LengthAwarePaginator Paginated vehicle results
     */
    public function getFilteredVehicles(int $ownerId, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $query = Vehicle::where('owner_id', $ownerId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('truck_number', 'like', '%' . $search . '%')
                  ->orWhere('rc_number', 'like', '%' . $search . '%');
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Get fleet statistics: total vehicle count and active vehicle count.
     *
     * @param int $ownerId The fleet owner's user ID
     * @return array Associative array with 'totalCount' and 'activeCount' keys
     */
    public function getStats(int $ownerId): array
    {
        return [
            'totalCount' => Vehicle::where('owner_id', $ownerId)->count(),
            'activeCount' => Vehicle::where('owner_id', $ownerId)->where('status', 'active')->count(),
        ];
    }
}
