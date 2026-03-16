<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Vehicle Model
 *
 * Represents a truck/vehicle in the fleet owner's garage. Stores all
 * registration details, compliance expiry dates, and uploaded documents.
 * The 'status' field tracks availability: 'active' (available for trips),
 * 'maintenance' (currently on a trip or under maintenance), or 'inactive'.
 *
 * @property int         $id
 * @property int         $owner_id                     The fleet owner who registered this vehicle
 * @property string      $truck_number                 Vehicle registration/number plate (stored uppercase)
 * @property string      $truck_type                   Type of truck (e.g., Open Body, Container, Tanker)
 * @property float|null  $capacity_tons                Load carrying capacity in metric tons
 * @property string|null $rc_number                    Registration Certificate number (stored uppercase)
 * @property string|null $chassis_number               Vehicle chassis number
 * @property string|null $engine_number                Vehicle engine number
 * @property string|null $insurance_expiry_date        Insurance policy expiry date
 * @property string|null $fitness_expiry_date          Fitness certificate expiry date
 * @property string|null $national_permit_expiry_date  National permit expiry date
 * @property string|null $pollution_expiry_date        Pollution Under Control (PUC) certificate expiry date
 * @property string|null $rc_document_path             File path to uploaded RC document
 * @property string|null $insurance_document_path      File path to uploaded insurance document
 * @property string|null $fitness_document_path        File path to uploaded fitness certificate
 * @property string|null $truck_photo_path             File path to uploaded truck photo
 * @property string      $status                       Vehicle availability: 'active', 'maintenance', or 'inactive'
 */
class Vehicle extends Model
{
    use HasFactory, BelongsToOwner;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'truck_number',
        'truck_type',
        'capacity_tons',
        'rc_number',
        'chassis_number',
        'engine_number',
        'insurance_expiry_date',
        'fitness_expiry_date',
        'national_permit_expiry_date',
        'pollution_expiry_date',
        'rc_document_path',
        'insurance_document_path',
        'fitness_document_path',
        'truck_photo_path',
        'status',
    ];
}
