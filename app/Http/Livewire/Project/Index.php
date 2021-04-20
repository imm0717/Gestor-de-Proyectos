<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithLogs;

class Index extends Component
{
    use WithPagination;
    use WithLogs;

    private $itemsPerPage = 8;

    public $parent_id = null;
    public $project = null;
    public $data = [];
    public $deleteModalId = "deleteProjectModal";

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete', 'selectProjectEndDate', 'selectProjectStartDate'];

    

    protected $rules = [
        'data.en.name' => 'required|string|max:50',
        'data.en.description' => 'required|string|max:256',
        'project.start_date' => 'required|date',
        'project.end_date' => 'required|date',
        'project.owner_id' => 'nullable',
        'project.created_by_id' => 'required',
        'project.parent_id' => 'nullable'
    ];

    protected $validationAttributes = [
        'project.start_date' => 'Start Date',
        'project.end_date' => 'End Date',
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
        $this->project = new Project();
        $this->project->parent_id = ($parent_id == "") ? null : $parent_id;
        $this->project->created_by_id = auth()->id();
        $this->project->start_date = Carbon::now()->format('d-m-Y');
        $this->project->end_date = Carbon::now()->addDay()->format('d-m-Y');

        if (isset($parent_id) && $parent_id != "") {
            $parent_project = Project::find($parent_id);
            $parent_translations = $parent_project->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = '';
            $this->data[$locale]['description'] = '';
            $this->data[$locale]['parent_name'] = (isset($parent_translations[$locale]['name'])) ? $parent_translations[$locale]['name'] : '';
        }

        $this->dispatchBrowserEvent('initCalendar');
    }

    public function edit($id)
    {

        $this->project = Project::findOrFail($id);
        $translations = $this->project->getTranslationsArray();
        $project_parent = $this->project->parent;

        if (isset($project_parent)) {
            $parent_translations = $this->project->parent->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = $translations[$locale]['name'];
            $this->data[$locale]['description'] = $translations[$locale]['description'];
            if (isset($project_parent) && count($parent_translations) > 0)
                $this->data[$locale]['parent_name'] = $parent_translations[$locale]['name'];
        }

        $this->dispatchBrowserEvent('initCalendar');
    }

    public function submit()
    {
        if ($this->project->id == "") {
            $log_action = WithLogs::$create;
            $log_message = "Proyecto creado";
        } else {
            $log_action = WithLogs::$update;
            $log_message = "Proyecto actualizado";
        }

        $this->validate($this->rules);

        foreach (config('translatable.locales') as $locale) {
            if (isset($this->data[$locale]['name'])) {
                $this->project->translateOrNew($locale)->name = $this->data[$locale]['name'];
            }
            if (isset($this->data[$locale]['description'])) {
                $this->project->translateOrNew($locale)->description = $this->data[$locale]['description'];
            }
        }

        try {
            $this->project->save();
            session()->flash('message', $log_message);
            $this->logActivity($log_action, $log_message, ['model' => Project::class, 'id' => $this->project->id]);
            $this->dispatchBrowserEvent('projectStored');
            $this->dispatchBrowserEvent('alert');
            $this->resetForm();
        } catch (QueryException $e) {
            session()->flash('message', "Error al gestionar Proyecto");
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Project::class, 'id' => isset($this->project->id) ? $this->project->id : null]);
            $this->dispatchBrowserEvent('alert');
        }
    }

    public function showDeleteConfirmationModal($id)
    {
        $this->project = Project::find($id);
        $this->dispatchBrowserEvent('show'.$this->deleteModalId);
    }

    public function delete()
    {
        try {
            $log_message = "Proyecto eliminado";
            $this->project->delete();
            session()->flash('message', $log_message);
            $this->logActivity(WithLogs::$delete, $log_message, ['model' => Project::class, 'id' => $this->project->id]);
            $this->dispatchBrowserEvent('alert');
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Project::class, 'id' => $this->project->id]);
            $this->dispatchBrowserEvent('alert');
        }

        $this->dispatchBrowserEvent('close'.$this->deleteModalId);
    }

    public function selectProjectStartDate($value)
    {
        $this->project->start_date = $value;
        $this->validateOnly('project.start_date');
    }

    public function selectProjectEndDate($value)
    {
        $this->project->end_date = $value;
        $this->validateOnly('project.end_date');
    }

    public function mount($parentId = null)
    {
        if (isset($parentId) && $parentId != ""){
            $this->project = Project::findOrFail($parentId);
        }
        $this->parent_id = $parentId;
    }

    public function render()
    {
        return view('livewire.project.index', [
            'projects' => Project::with('translations')->with('childs')->with('owner')->with('creator')->with('members')->where('parent_id', $this->parent_id)->latest()->paginate($this->itemsPerPage),
            'users' => User::all(),
            'locales' => config('translatable.locales'),
            'default_locale' => config('app.locale')
        ]);
    }
}
