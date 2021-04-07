<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $itemsPerPage = 10;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['selectEndDate', 'selectStartDate'];


    public $project = null;

    protected $rules = [
        'project.name' => 'string|max:256',
        'project.start_date' => 'required|date',
        'project.end_date' => 'required|date',
        'project.description' => 'string|max:256',
        'project.created_by_id' => 'required'
    ];

    public function resetForm(){
        $this->resetValidation();
        $this->project = new Project();
        $this->project->created_by_id = auth()->id();
    }

    public function edit($id){
        $this->resetForm();
        $this->project = Project::findOrFail($id);
    }

    public function submit(){
        $this->validate($this->rules);
        $this->project->save();
        $this->dispatchBrowserEvent('projectStored');
    }

    public function showDeleteConfirmationModal($id){
        $this->project = Project::find($id);
    }

    public function delete(){
        $this->project->delete();
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    public function selectStartDate($value){
        $this->project->start_date = Carbon::createFromTimestamp($value)->toDateString();
    }

    public function selectEndDate($value){
        $this->project->end_date = Carbon::createFromTimestamp($value)->toDateString();
    }

    public function render(){
        return view('livewire.project.index', [
            'projects' => Project::latest()->paginate($this->itemsPerPage)
        ]);
    }
}
