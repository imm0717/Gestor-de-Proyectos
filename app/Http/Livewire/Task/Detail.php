<?php

namespace App\Http\Livewire\Task;

use App\Traits\WithLogs;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Database\QueryException;

class Detail extends Component
{
    use WithLogs;

    public $task;
    public $responsible;
    public $completed = false;

    protected $rules = [
        'responsible' => 'nullable',
        'completed' => 'nullable'
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
            session()->flash('message', __('view.partials.alert.info-body'));
            $this->dispatchBrowserEvent('alert');
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Task::class, 'id' => $this->task->id]);
            session()->flash('error', __('view.partials.alert.error-body'));
            $this->dispatchBrowserEvent('alert');
        }
    }

    public function updatedCompleted($value)
    {
        try {
            if ($value) {
                $this->task->real_end_date = Carbon::now()->format('d-m-Y');
                $log_message = "Tarea marcada como completada";
            }else{
                $this->task->real_end_date = null;
                $log_message = "Tarea marcada como no completada";
            }
            $this->task->save();
            $this->task->refresh();
            $this->logActivity(WithLogs::$update, $log_message, ['model' => Task::class, 'id' => $this->task->id]);
            session()->flash('message', __('view.partials.alert.info-body'));
            $this->dispatchBrowserEvent('alert');

        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Task::class, 'id' => $this->task->id]);
            session()->flash('error', __('view.partials.alert.error-body'));
            $this->dispatchBrowserEvent('alert');
        }
    }

    public function mount()
    {
        $this->responsible = $this->task->responsible_id;
        $this->completed = ($this->task->real_end_date != null) ? true : false;
    }

    public function render()
    {
        return view('livewire.task.detail', [
            'users' => $this->getUsers(),
            'default_locale' => config('app.locale')
        ]);
    }
}
