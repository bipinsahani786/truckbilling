<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // A User (Driver) belongs to a User (Owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // A User (Owner) has many Drivers
    public function drivers()
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    // A User (Owner) has many Vehicles
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'owner_id');
    }

    // A User (Owner) has many Dealers
    public function dealers()
    {
        return $this->hasMany(Dealer::class, 'owner_id');
    }

    /**
     * Get the user's initials for the profile avatar.
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
