<?php

namespace App\Http\Livewire\Project;

use App\Models\Permission;
use App\Models\ProjectMember;
use App\Models\User;
use Livewire\Component;

class Members extends Component
{
    public $project;
    public $editedMemberIndex = -1;
    public $permissions;
    public $selected = [];

    protected $listeners = [
        'addUserAsMember' => 'addMember',
        'savePermission'
    ];

    private function getMembers()
    {
        return $this->project->members;
    }

    public function updatedSelected($value){
        $this->dispatchBrowserEvent('initSelect', $value);
    }

    public function addMember($user_id)
    {
        if (isset($user_id)) {
            $user = User::find($user_id);
            $this->project->members()->save($user, ['permission' => json_encode(array('0' => 'all'))]);
            $this->project->refresh();
            $this->editedMemberIndex = -1;
        }
    }

    public function removeMember($id){
        $member = ProjectMember::findOrFail($id);
        $member->delete();
        $this->project->refresh();
    }

    public function editPermissions($index, $values){
        $this->editedMemberIndex = $index;
        $this->dispatchBrowserEvent('selectPicker', ['values' => $values]);
    }

    public function savePermission($user_id){
        if (isset($user_id)) {
            $this->project->members()->updateExistingPivot($user_id, ['permission' => $this->selected]);
            $this->project->refresh();
            $this->editedMemberIndex = -1;
        }
    }

    public function mount()
    {
        $this->members = $this->getMembers();
        $this->permissions = Permission::all();
    }

    public function render()
    {
        return view('livewire.project.members', [
            'members' => $this->getMembers(),
            'users' => User::all()->diff($this->getMembers())
        ]);
    }
}
