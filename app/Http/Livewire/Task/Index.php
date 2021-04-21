<?php

namespace App\Http\Livewire\Task;

use App\Models\Project;
use App\Models\Task;
use App\Traits\WithLogs;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithLogs;

    private $itemsPerPage = 10;
    
    public $project;
    public $parent_id;
    public $project_id;
    public $task;
    public $data = [];
    public $deleteModalId = "deleteTaskModal";
    
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete','selectEndDate', 'selectStartDate'];

    protected $rules = [
        'data.en.name' => 'required|string|max:50',
        'data.en.description' => 'required|string|max:256',
        'task.project_id' => 'required|string',
        'task.start_date' => 'required|date',
        'task.end_date' => 'required|date',
        'task.responsible_id' => 'nullable',
        'task.created_by_id' => 'required',
        'task.parent_id' => 'nullable'
    ];

    protected $validationAttributes = [
        'task.start_date' => 'Start Date',
        'task.end_date' => 'End Date',
        'data.en.name' => 'Name',
        'data.es.name' => 'Nombre',
        'data.en.description' => 'Description',
        'data.es.description' => 'Descripción'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function resetForm($parent_id = null)
    {
        $this->resetValidation();
        $this->task = new Task();
        $this->task->parent_id = (isset($parent_id) && $parent_id != "") ? $parent_id : null;
        $this->task->created_by_id = auth()->id();
        $this->task->start_date = Carbon::now()->format('d-m-Y');
        $this->task->end_date = Carbon::now()->addDay()->format('d-m-Y');

        if (isset($parent_id) && $parent_id != "") {
            $parent_task = Task::find($parent_id);
            $this->task->project_id = $parent_task->project->id;
            $parent_translations = $parent_task->getTranslationsArray();
        }else{
            $this->task->project_id = (isset($this->project_id) && $this->project_id != "") ? $this->project_id : null;
        }
        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = '';
            $this->data[$locale]['description'] = '';
            $this->data[$locale]['parent_name'] = (isset($parent_translations[$locale]['name'])) ? $parent_translations[$locale]['name'] : '';
        }
    }

    public function edit($id)
    {
        $this->task = Task::findOrFail($id);
        $translations = $this->task->getTranslationsArray();
        $task_parent = $this->task->parent;
        if (isset($task_parent)) {
            $parent_translations = $this->task->parent->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = $translations[$locale]['name'];
            $this->data[$locale]['description'] = $translations[$locale]['description'];
            if (isset($task_parent) && count($parent_translations) > 0)
                $this->data[$locale]['parent_name'] = $parent_translations[$locale]['name'];
        }
    }

    public function submit()
    {
        if ($this->task->id == "") {
            $log_action = WithLogs::$create;
            $log_message = "Task created";
        } else {
            $log_action = WithLogs::$update;
            $log_message = "Task updated";
        }


        $this->validate($this->rules);

        foreach (config('translatable.locales') as $locale) {
            if (isset($this->data[$locale]['name'])) {
                $this->task->translateOrNew($locale)->name = $this->data[$locale]['name'];
            }
            if (isset($this->data[$locale]['description'])) {
                $this->task->translateOrNew($locale)->description = $this->data[$locale]['description'];
            }
        }

        try {
            $this->task->save();
            $this->logActivity($log_action, $log_message, ['model' => Task::class, 'id' => $this->task->id]);
            $this->dispatchBrowserEvent('closeModal');
            $this->resetForm();
            session()->flash('message', __('view.partials.alert.info-body'));
            $this->dispatchBrowserEvent('alert');
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Task::class, 'id' => isset($this->task->id) ? $this->task->id : null]);
            session()->flash('error', __('view.partials.alert.error-body'));
            $this->dispatchBrowserEvent('alert');
        }
    }

    public function selectStartDate($value)
    {
        $this->task->start_date = $value;
        $this->validateOnly('task.start_date');
    }

    public function selectEndDate($value)
    {
        $this->task->end_date = $value;
        $this->validateOnly('task.end_date');
    }

    public function showDeleteConfirmationModal($id)
    {
        $this->task = Task::find($id);
        $this->dispatchBrowserEvent('show'.$this->deleteModalId);
    }

    public function delete()
    {
        try {
            $log_message = "Tarea eliminada";
            $this->task->delete();
            $this->logActivity(WithLogs::$delete, $log_message, ['model' => Task::class, 'id' => $this->task->id]);
            session()->flash('message', __('view.partials.alert.info-body'));
            $this->dispatchBrowserEvent('alert');
            
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Task::class, 'id' => $this->task->id]);
            session()->flash('error', __('view.partials.alert.error-body'));
            $this->dispatchBrowserEvent('alert');
        }
        $this->dispatchBrowserEvent('close'.$this->deleteModalId);
    }

    public function getTasks()
    {
        if ($this->parent_id == null) {
            if ($this->project_id == null){
                return Task::with('translations')
                ->with('childs')
                ->where('real_end_date', '=' , null, 'and')
                ->where('created_by_id', auth()->id())
                ->orWhere('responsible_id', auth()->id())
                ->orderBy('end_date', 'asc')
                ->paginate($this->itemsPerPage);
            }else
                return Task::with('translations')->with('childs')->where('project_id', '=', $this->project_id, 'and')->where('parent_id', null)->latest()->paginate($this->itemsPerPage);
        } else {
            return Task::with('translations')->with('childs')->where('project_id', '=', $this->project_id, 'and')->where('parent_id', $this->parent_id)->latest()->paginate($this->itemsPerPage);
        }
    }

    public function mount($projectId, $parentId)
    {
        if (isset($projectId) && $projectId != ""){
            $this->project = Project::findOrFail($projectId);
        }
        $this->project_id = $projectId;
        $this->parent_id = $parentId;
    }

    public function render()
    {
        return view('livewire.task.index', [
            'tasks' => $this->getTasks()
        ]);
    }
}
