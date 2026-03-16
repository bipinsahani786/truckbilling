<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

/**
 * Login Livewire Component
 *
 * Handles user authentication using either email or mobile number.
 * Automatically detects whether the input is an email or mobile number
 * and authenticates accordingly. Also checks if the user's account is blocked.
 */
#[Layout('layouts.guest')]
class Login extends Component
{
    /** @var string Email address or mobile number for login */
    public $login_id;
    /** @var string User's password */
    public $password;
    /** @var bool Whether to remember the login session */
    public $remember = false;

    /**
     * Attempt to authenticate the user.
     *
     * Detects input type (email vs mobile), attempts login, and checks
     * if the account is blocked before allowing access.
     */
    public function login()
    {
        $this->validate([
            'login_id' => 'required|string',
            'password' => 'required',
        ]);

        // Determine the field type: if input is a valid email, use 'email' column; otherwise use 'mobile_number'
        $fieldType = filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        // Attempt authentication
        if (Auth::attempt([$fieldType => $this->login_id, 'password' => $this->password], $this->remember)) {
            // Check if the user's account has been blocked by super-admin
            if (Auth::user()->is_blocked) {
                Auth::logout();
                $this->addError('login_id', 'Your account has been blocked. Please contact the administrator.');
                return;
            }

            // Regenerate session to prevent session fixation attacks
            session()->regenerate();

            // Redirect super-admin to user management page directly
            if (Auth::user()->hasRole('super-admin')) {
                return redirect()->intended(route('admin.users', absolute: false));
            }

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Login failed: show error message
        $this->addError('login_id', 'Invalid email/mobile number or password. Please try again.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}