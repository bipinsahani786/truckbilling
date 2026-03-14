<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

class ProfileSettings extends Component
{
    #[Layout('layouts.app')]

    // Profile Fields
    public $name;
    public $email;
    public $mobile_number;

    // Password Fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile_number = $user->mobile_number;
    }

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

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:6|confirmed', // Yeh automatically new_password_confirmation check karega
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('password_success', 'Password Changed Successfully!');
    }

    public function render()
    {
        return view('livewire.admin.profile-settings');
    }
}