<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Model;

/**
 * Trip Model
 *
 * Represents a single freight trip from origin to destination.
 * A trip is assigned to a specific vehicle and driver, and optionally
 * linked to a dealer. It tracks the complete lifecycle from creation
 * through in-transit, completion, and final settlement.
 *
 * @property int         $id
 * @property int         $owner_id              The fleet owner managing this trip
 * @property int         $driver_id             The driver assigned to this trip
 * @property int         $vehicle_id            The vehicle used for this trip
 * @property int|null    $dealer_id             The dealer/party who booked this trip (optional)
 * @property string      $from_location         Starting location (stored in uppercase)
 * @property string      $to_location           Destination location (stored in uppercase)
 * @property string|null $material_description  Description of the cargo/material being transported
 * @property float|null  $weight_tons           Weight of the cargo in metric tons
 * @property float|null  $party_freight_amount  Agreed freight amount from the party
 * @property float|null  $driver_advance        Advance amount given to the driver
 * @property string      $status                Trip lifecycle status: scheduled|loaded|in_transit|unloaded|completed|settled
 * @property string      $pod_status            Proof of Delivery status
 * @property string|null $pod_document_path     File path to the uploaded POD document
 * @property string      $start_date            Date when the trip started
 * @property string|null $end_date              Date when the trip was completed
 */
class Trip extends Model
{
    use BelongsToOwner;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'owner_id', 'trip_number', 'driver_id', 'vehicle_id', 'dealer_id',
        'from_location', 'to_location', 'material_description', 'weight_tons',
        'party_freight_amount', 'driver_advance', 'status', 'pod_status',
        'pod_document_path', 'start_date', 'end_date',
    ];

    /**
     * Get the driver assigned to this trip.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Get the vehicle used for this trip.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /**
     * Get the dealer/party associated with this trip.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }

    /**
     * Get all financial transactions (expenses and recoveries) for this trip.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(TripTransaction::class);
    }
}
