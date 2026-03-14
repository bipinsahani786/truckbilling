<?php

namespace App\Livewire\Admin; // 'Admin' add ho gaya

use Livewire\Component;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    #[Layout('layouts.app')] 
    public function render()
    {
        // Yahan 'admin.' batata hai ki file admin folder ke andar hai
        return view('livewire.admin.dashboard'); 
    }
}