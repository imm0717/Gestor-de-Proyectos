<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Livewire\Component;

class Index extends Component
{
    public $projects;
    public $form = null;

    protected $rules = [
        'form.name' => 'string|max:256',
        'form.start_date' => 'required|date',
        'form.end_date' => 'required|date'
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

    public function edit($project){
        $this->form = $project;
    }

    public function render()
    {
        return view('livewire.project.index');
    }

    public function mount(){
        $this->loadProjects();

    }
}
