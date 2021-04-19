<?php

namespace App\Http\Livewire\Task;

use App\Traits\WithLogs;
use Livewire\Component;
use Illuminate\Database\QueryException;

class Detail extends Component
{
    use WithLogs;

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
        $log_message = "Responsable de la Tarea actualizado";
        $this->task->responsible_id = ($responsible_id != "") ? $responsible_id : null;
        
        try {
            $this->task->save();
            $this->task->refresh();
            $this->logActivity(WithLogs::$update, $log_message, ['model' => Task::class, 'id' => $this->task->id]);
            //$this->emit('responsibleChanged');
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Task::class, 'id' => $this->task->id]);
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
