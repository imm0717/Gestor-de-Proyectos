<?php

namespace App\Http\Livewire\Project;

use App\Models\User;
use Illuminate\Database\QueryException;
use Livewire\Component;
use App\Traits\WithLogs;

class Detail extends Component
{
    use WithLogs;

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
        $log_message = "Encargado del Proyecto actualizado";
        $this->project->owner_id = ($owner_id != "") ? $owner_id : null;
        try {
            $this->project->save();
            $this->project->refresh();
            session()->flash('message', __('view.partials.alert.info-body'));
            $this->dispatchBrowserEvent('alert');
            $this->logActivity(WithLogs::$update, $log_message, ['model' => Project::class, 'id' => $this->project->id]);
            $this->emit('ownerChanged');
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Project::class, 'id' => $this->project->id]);
            session()->flash('error', __('view.partials.alert.error-body'));
            $this->dispatchBrowserEvent('alert');
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
