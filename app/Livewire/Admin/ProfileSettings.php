<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

/**
 * ProfileSettings Livewire Component
 *
 * Allows users to update their profile information (name, email, phone)
 * and change their password. This component is lightweight and does not
 * require a dedicated service class since no complex business logic is involved.
 */
class ProfileSettings extends Component
{
    #[Layout('layouts.app')]

    // --- Profile Form Properties ---
    /** @var string User's full name */
    public $name;
    /** @var string User's email address */
    public $email;
    /** @var string User's mobile number */
    public $mobile_number;

    // --- Password Change Form Properties ---
    /** @var string Current password (for verification) */
    public $current_password;
    /** @var string New password to set */
    public $new_password;
    /** @var string Confirmation of the new password */
    public $new_password_confirmation;

    /**
     * Initialize the form with the authenticated user's current details.
     */
    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile_number = $user->mobile_number;
    }

    /**
     * Validate and update the user's profile information.
     * Email and mobile number must remain unique across all users.
     */
    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile_number' => 'required|string|unique:users,mobile_number,' . $user->id,
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
        ]);

        session()->flash('profile_success', 'Profile Details Updated Successfully!');
    }

    /**
     * Validate the current password and update to the new password.
     * The 'confirmed' validation rule automatically checks the confirmation field.
     */
    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:6|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('password_success', 'Password Changed Successfully!');
    }

    /**
     * Render the profile settings view.
     */
    public function render()
    {
        return view('livewire.admin.profile-settings');
    }
}