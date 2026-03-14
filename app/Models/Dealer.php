<?php

namespace App\Models;

use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory, BelongsToOwner; // Trait injected here

    protected $fillable = [
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
