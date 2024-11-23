<?php

namespace App\Livewire;

use Livewire\Component;

class Appointments extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.appointments');
    }
}
