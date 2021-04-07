<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        //$this->teams = Team::all();
    }
    public function render()
    {
        return view('livewire.team.show', [
            'teams' => Team::paginate(2)
        ]);
    }
}
