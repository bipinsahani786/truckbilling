<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * TripBilling Model
 *
 * Represents a single party billing entry for a trip. A trip can have
 * multiple independent billing records (multi-party billing), each with
 * its own party name, material, weight, freight amount, and received amount.
 * This supports scenarios where a single trip carries goods for multiple parties.
 *
 * @property int         $id
 * @property int         $trip_id               The trip this billing entry belongs to
 * @property string|null $party_name            Name of the party being billed
 * @property string|null $material_description  Description of the material for this billing
 * @property float|null  $weight_tons           Weight of material in metric tons
 * @property float       $freight_amount        Total freight amount agreed with the party
 * @property float       $received_amount       Amount actually received from the party so far
 */
class TripBilling extends Model
{
    /**
     * Explicitly specify the table name since Laravel would expect 'trip_billings' by convention.
     */
    protected $table = 'trip_billing';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'trip_id',
        'party_name',
        'material_description',
        'weight_tons',
        'freight_amount',
        'received_amount',
    ];
}
