<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use BelongsToOwner;

    protected $fillable = [
        'owner_id', 'driver_id', 'vehicle_id', 'dealer_id', 
        'from_location', 'to_location', 'material_description', 'weight_tons',
        'party_freight_amount', 'driver_advance', 'status', 'pod_status', 
        'pod_document_path', 'start_date', 'end_date'
    ];

    public function driver() { return $this->belongsTo(User::class, 'driver_id'); }
    public function vehicle() { return $this->belongsTo(Vehicle::class, 'vehicle_id'); }
    public function dealer() { return $this->belongsTo(Dealer::class, 'dealer_id'); }
    public function transactions() { return $this->hasMany(TripTransaction::class);
     }
}
