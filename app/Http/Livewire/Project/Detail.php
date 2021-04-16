<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Detail extends Component
{
    public $project;

    protected $rules = [
        'project.owner_id' => 'nullable'
        ];
    protected $listeners = ['setOwner'];

    private function getUsers(){
        if (isset($this->project->parent)){
            return $this->project->parent->members;
        }else{
            return User::all();
        }
    }

    public function setOwner($id){
        $project = Project::find($this->project->id);
        $project->owner_id = ($id != "") ? $id : null;
        try{
            $project->save();
        }catch (QueryException $e){
            session()->flash('message','Error');
        }
    }

    public function render()
    {
        return view('livewire.project.detail', [
            'users' => $this->getUsers(),
            'default_locale' => config('app.locale')
        ]);
    }
}
