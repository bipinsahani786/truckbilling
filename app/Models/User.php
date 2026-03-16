<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * User Model
 *
 * Represents both fleet owners and drivers in the system.
 * - An **Owner** is a top-level user who manages vehicles, drivers, dealers, and trips.
 * - A **Driver** is a user with an owner_id pointing to their fleet owner.
 *
 * Roles are managed via Spatie's HasRoles trait ('owner', 'driver', 'super-admin').
 * API authentication is provided by Laravel Sanctum's HasApiTokens trait.
 *
 * @property int         $id
 * @property int|null    $owner_id              Parent owner ID (null for owners, set for drivers)
 * @property string      $name                  Full name of the user
 * @property string      $email                 Email address (used for login)
 * @property string|null $mobile_number         10-digit mobile number
 * @property string|null $address               Residential address
 * @property string      $password              Hashed password (auto-cast via 'hashed')
 * @property string|null $company_name          Company/fleet name (for owners)
 * @property string|null $blood_group           Blood group of the user
 * @property string|null $aadhar_number         12-digit Aadhaar number (Indian national ID)
 * @property string|null $license_number        Driving license number
 * @property string|null $aadhar_document_path  File path to uploaded Aadhaar document
 * @property string|null $license_document_path File path to uploaded license document
 * @property string|null $profile_photo_path    File path to the user's profile photo
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'owner_id',
        'name',
        'email',
        'mobile_number',
        'address',
        'password',
        'company_name',
        'blood_group',
        'aadhar_number',
        'license_number',
        'aadhar_document_path',
        'license_document_path',
        'profile_photo_path',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden in serialized output (e.g., JSON/API responses).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define attribute casting rules.
     * The 'hashed' cast automatically hashes the password when it is set.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the fleet owner that this driver belongs to.
     * Only applicable for users with the 'driver' role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all drivers managed by this fleet owner.
     * Only applicable for users with the 'owner' role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drivers()
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    /**
     * Get all vehicles owned by this fleet owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'owner_id');
    }

    /**
     * Get all dealers/parties registered by this fleet owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dealers()
    {
        return $this->hasMany(Dealer::class, 'owner_id');
    }

    /**
     * Generate initials from the user's name for avatar display.
     * Uses the first letter of the first two words, or the first two
     * letters if the name has only one word.
     *
     * @return string Uppercase initials (e.g., "BS" for "Bipin Sahani")
     */
    public function initials(): string
    {
        $name = $this->name;
        $words = explode(' ', $name);

        if (count($words) >= 2) {
            return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        }

        return mb_strtoupper(mb_substr($name, 0, 2));
    }
}
