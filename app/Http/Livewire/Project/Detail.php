<?php

namespace App\Http\Livewire\Project;

use App\Models\User;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Detail extends Component
{
    public $project;
    public $owner;

    protected $rules = [
        'owner' => 'nullable'
    ];

    private function getUsers()
    {
        if (isset($this->project->parent)) {
            return $this->project->parent->members;
        } else {
            return User::all();
        }
    }

    public function updatedOwner($owner_id)
    {
        $this->project->owner_id = ($owner_id != "") ? $owner_id : null;
        try {
            $this->project->save();
            $this->project->refresh();
            $this->emit('ownerChanged');
        } catch (QueryException $e) {
            session()->flash('message', 'Error');
        }
    }

    public function mount()
    {
        $this->owner = $this->project->owner_id;
    }

    public function render()
    {
        return view('livewire.project.detail', [
            'users' => $this->getUsers(),
            'default_locale' => config('app.locale')
        ]);
    }
}
