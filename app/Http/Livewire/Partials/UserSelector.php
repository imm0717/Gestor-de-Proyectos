<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class UserSelector extends Component
{
    public $label = '';


    public function render()
    {
        return view('livewire.partials.user-selector');
    }
}
