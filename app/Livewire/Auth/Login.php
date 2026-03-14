<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class Login extends Component
{
    public $login_id; // Ye email aur mobile dono handle karega
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'login_id' => 'required|string',
            'password' => 'required',
        ]);

        // Logic: Agar '@' hai aur valid email format hai, toh 'email' column check karo, 
        // warna 'mobile_number' column check karo.
        $fieldType = filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        // Attempt to login manually dynamically based on field type
        if (Auth::attempt([$fieldType => $this->login_id, 'password' => $this->password], $this->remember)) {
            // Security best practice: Regenerate session to prevent fixation
            session()->regenerate();
            
            return redirect()->intended('dashboard');
        }

        // If login fails
        $this->addError('login_id', 'Email/Mobile number ya password galat hai. Kripya dobara try karein.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}