<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Index extends Component
{
    public $project;
    private $itemsPerPage = 10;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['selectEndDate', 'selectStartDate'];

    public $task;
    public $data = [];

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


    public function resetForm($parent_id = null){
        $this->resetValidation();
        $this->task = new Task();
        $this->task->project_id = $this->project->id;
        $this->task->parent_id = $parent_id;
        $this->task->created_by_id = auth()->id();

        if (isset($parent_id)){
            $parent_task = Task::find($parent_id);
            $parent_translations = $parent_task->getTranslationsArray();
        }
        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = '';
            $this->data[$locale]['description'] = '';
            $this->data[$locale]['parent_name'] = (isset($parent_translations[$locale]['name'])) ? $parent_translations[$locale]['name'] : '';
        }
    }

    public function edit($id){
        $this->task = Task::findOrFail($id);
        $translations = $this->task->getTranslationsArray();
        $task_parent = $this->task->parent;
        if (isset($task_parent)){
            $parent_translations = $this->task->parent->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale){
            $this->data[$locale]['name'] = $translations[$locale]['name'];
            $this->data[$locale]['description'] = $translations[$locale]['description'];
            if ( isset($task_parent) && count($parent_translations) > 0 )
                $this->data[$locale]['parent_name'] = $parent_translations[$locale]['name'];
        }
    }

    public function submit(){
        $this->validate($this->rules);

        foreach (config('translatable.locales') as $locale){
            if (isset($this->data[$locale]['name'])){
                $this->task->translateOrNew($locale)->name = $this->data[$locale]['name'];
            }
            if (isset($this->data[$locale]['description'])){
                $this->task->translateOrNew($locale)->description = $this->data[$locale]['description'];
            }
        }

       // try{
            $this->task->save();
            $this->dispatchBrowserEvent('closeModal');
            $this->resetForm();
            session()->flash('message', 'Todo OK');

        /*}catch(QueryException $e){
            session()->flash('message', 'Ocurrio un error');
        }*/
    }

    public function selectStartDate($value){
        $this->task->start_date = $value;
        $this->validateOnly('task.start_date');
    }

    public function selectEndDate($value){
        $this->task->end_date = $value;
        $this->validateOnly('task.end_date');
    }

    public function showDeleteConfirmationModal($id){
        $this->task = Task::find($id);
    }

    public function delete(){
        $this->task->delete();
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    public function getTasks(){
        if ($this->project == null){
            return Task::with('translations')->with('childs')->where('parent_id', null)->paginate($this->itemsPerPage);
        }else{
            return Task::with('translations')->with('childs')->where('project_id', '=', $this->project->id, 'and' )->where('parent_id', null)->paginate($this->itemsPerPage);
        }
    }

    public function mount($project){
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.task.index', [
            'tasks' => $this->getTasks()
        ]);
    }
}
