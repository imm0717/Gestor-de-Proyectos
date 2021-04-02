<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Livewire\Component;

class Show extends Component
{
    public $teams;

    public function mount()
    {
        $this->teams = Team::all();
    }
    public function render()
    {
        return view('livewire.team.show');
    }
}
