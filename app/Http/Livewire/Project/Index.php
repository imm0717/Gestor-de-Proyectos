<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $itemsPerPage = 10;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['selectEndDate', 'selectStartDate'];

    public $project = null;
    public $data = [];
    public $multilanguage_keys = ['name', 'description'];
    public $selectedTab = '';

    protected $rules = [
        'data.en.name' => 'required|string|max:50',
        'data.en.description' => 'required|string|max:256',
        'project.start_date' => 'required|date',
        'project.end_date' => 'required|date',
        'project.created_by_id' => 'required'
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


    public function resetForm(){
        $this->resetValidation();
        $this->project = new Project();
        $this->project->created_by_id = auth()->id();
        foreach (config('translatable.locales') as $locale) {
            $this->data[$locale]['name'] = '';
            $this->data[$locale]['description'] = '';
        }
    }

    public function edit($id){
        $this->resetForm();
        $this->project = Project::findOrFail($id);
        $translations = $this->project->getTranslationsArray();

        foreach (config('translatable.locales') as $locale){
            $this->data[$locale]['name'] = $translations[$locale]['name'];
            $this->data[$locale]['description'] = $translations[$locale]['description'];
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
            'projects' => Project::with('translations')->paginate($this->itemsPerPage),
            'locales' => config('translatable.locales'),
            'default_locale' => config('app.locale')
        ]);
    }
}
