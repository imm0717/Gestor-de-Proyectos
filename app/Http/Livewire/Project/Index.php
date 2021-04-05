<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Livewire\Component;

class Index extends Component
{
    public $projects;
    public $project = null;

    protected $rules = [
        'project.name' => 'string|max:256',
        'project.start_date' => 'required|date',
        'project.end_date' => 'required|date',
        'project.description' => 'string'
    ];

    /*protected $listeners = [
        'newProject' => 'newProjectHandler',
        'projectChange' => 'projectChangeHandler'
    ];*/

    private function loadProjects(){
        $this->projects = Project::latest()->get();
    }


    /*public function editBtnHandler($project){
        $this->emit('editProject', $project);
    }

    public function projectChangeHandler(){
        $this->projects = $this->projects->fresh();
    }

    public function newProjectHandler(){
        $this->loadProjects();
    }*/

    public function resetForm(){
        $this->resetValidation();
        $this->project = new Project();
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

    public function render()
    {
        return view('livewire.project.index');
    }

    public function mount(){
        $this->loadProjects();
    }
}
