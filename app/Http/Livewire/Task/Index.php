<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Livewire\Component;

class Index extends Component
{
    public $project_id;
    protected $listeners = ['showTaskModal','closeTaskModal'];

    public function showTaskModal(){
        $this->dispatchBrowserEvent('showModal');
    }

    public function closeTaskModal(){
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('livewire.task.index', [
            'tasks' => Task::where('project_id', $this->project_id )->paginate(10)
        ]);
    }
}
