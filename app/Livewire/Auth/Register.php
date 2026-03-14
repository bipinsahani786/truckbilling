<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')] // Hum apna banaya hua desi theme layout use karenge
class Register extends Component
{
    public $name, $company_name, $mobile_number, $email, $password, $password_confirmation;

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 1. Create User
        $user = User::create([
            'name' => $this->name,
            'company_name' => $this->company_name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // 2. Assign Role (Spatie)
        $user->assignRole('owner');

        // 3. Login the user automatically
        Auth::login($user);

        // 4. Redirect to Dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}