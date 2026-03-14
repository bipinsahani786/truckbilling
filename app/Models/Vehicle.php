<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, BelongsToOwner; // Trait injected here

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
