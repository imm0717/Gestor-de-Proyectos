<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use Illuminate\Database\QueryException;

class Detail extends Component
{
    public $task;
    public $responsible;
    
    protected $rules = [
        'responsible' => 'nullable'
    ];

    private function getUsers()
    {
        if (isset($this->task->project)) {
            return $this->task->project->members;
        }
    }

    public function updatedResponsible($responsible_id)
    {
        $this->task->responsible_id = ($responsible_id != "") ? $responsible_id : null;
        try {
            $this->task->save();
            $this->task->refresh();
            //$this->emit('responsibleChanged');
        } catch (QueryException $e) {
            session()->flash('message', 'Error');
        } 
    }

    public function mount()
    {
        $this->responsible = $this->task->responsible_id;
    }

    public function render()
    {
        //dd($this->task->project);
        return view('livewire.task.detail', [
            'users' => $this->getUsers(),
            'default_locale' => config('app.locale')
        ]);
    }
}
