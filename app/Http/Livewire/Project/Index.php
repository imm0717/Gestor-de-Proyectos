<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $itemsPerPage = 4;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['selectEndDate', 'selectStartDate'];

    public $project = null;
    public $data = [];

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


    public function resetForm($parent_id = null){
        $this->resetValidation();
        $this->project = new Project();
        $this->project->parent_id = $parent_id;
        $this->project->created_by_id = auth()->id();
        $this->project->start_date = Carbon::now()->format('d-m-Y');
        $this->project->end_date = Carbon::now()->addDay()->format('d-m-Y');

        if (isset($parent_id)){
            $parent_project = Project::find($parent_id);
            $parent_translations = $parent_project->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = '';
            $this->data[$locale]['description'] = '';
            $this->data[$locale]['parent_name'] = (isset($parent_translations[$locale]['name'])) ? $parent_translations[$locale]['name'] : '';
        }
    }

    public function edit($id){
        $this->project = Project::findOrFail($id);
        $translations = $this->project->getTranslationsArray();
        $project_parent = $this->project->parent;
        if (isset($project_parent)){
            $parent_translations = $this->project->parent->getTranslationsArray();
        }

        foreach (config('translatable.locales') as $locale){
            $this->data[$locale]['name'] = $translations[$locale]['name'];
            $this->data[$locale]['description'] = $translations[$locale]['description'];
            if ( isset($project_parent) && count($parent_translations) > 0 )
                $this->data[$locale]['parent_name'] = $parent_translations[$locale]['name'];
        }
    }

    public function submit(){
        $this->validate($this->rules);

        foreach (config('translatable.locales') as $locale){
            if (isset($this->data[$locale]['name'])){
                $this->project->translateOrNew($locale)->name = $this->data[$locale]['name'];
            }
            if (isset($this->data[$locale]['description'])){
                $this->project->translateOrNew($locale)->description = $this->data[$locale]['description'];
            }
        }

        try{
            $this->project->save();
            $this->dispatchBrowserEvent('projectStored');
            $this->resetForm();
            session()->flash('message', 'Todo OK');

        }catch(QueryException $e){
            session()->keep('message', 'Ocurrio un error');
        }
    }

    public function showDeleteConfirmationModal($id){
        $this->project = Project::find($id);
    }

    public function delete(){
        $this->project->delete();
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    public function selectStartDate($value){
        $this->project->start_date = $value;
        $this->validateOnly('project.start_date');
    }

    public function selectEndDate($value){
        $this->project->end_date = $value;
        $this->validateOnly('project.end_date');
    }

    public function render(){
        return view('livewire.project.index', [
            'projects' => Project::with('translations')->with('childs')->with('owner')->with('creator')->with('members')->where('parent_id', null)->paginate($this->itemsPerPage),
            'users' => User::all(),
            'locales' => config('translatable.locales'),
            'default_locale' => config('app.locale')
        ]);
    }
}
