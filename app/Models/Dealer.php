<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Dealer Model
 *
 * Represents a business party / dealer / client who books freight trips.
 * Each dealer is owned by a specific fleet owner and contains business
 * details like GSTIN, PAN, and billing address for invoicing purposes.
 *
 * @property int         $id
 * @property int         $owner_id              The fleet owner who registered this dealer
 * @property string      $company_name          Dealer's business/company name
 * @property string|null $contact_person_name   Name of the primary contact person
 * @property string|null $gstin                 GST Identification Number (15 characters)
 * @property string|null $pan_number            PAN card number (10 characters)
 * @property string|null $phone_number          Primary phone number
 * @property string|null $alternate_phone       Secondary/alternate phone number
 * @property string|null $email                 Email address
 * @property string|null $billing_address       Full billing address
 * @property string|null $city                  City name
 * @property string|null $state                 State name
 * @property string|null $pincode               Postal/PIN code (6 digits)
 */
class Dealer extends Model
{
    use HasFactory, BelongsToOwner;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'owner_id',
        'company_name',
        'contact_person_name',
        'gstin',
        'pan_number',
        'phone_number',
        'alternate_phone',
        'email',
        'billing_address',
        'city',
        'state',
        'pincode',
    ];
}
