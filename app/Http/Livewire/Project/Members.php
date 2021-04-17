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
        'ownerChanged' => 'ownerChangedHandler',
        'savePermission'
        
    ];

    private function getMembers()
    {
        return $this->project->members;
    }

    private function getUsers()
    {

        $actual_members = $this->getMembers()->all();

        if (isset($this->project->owner)) {
            array_push($actual_members, $this->project->owner);
        }

        if (isset($this->project->parent)) {
            return $this->project->parent->members->diff($actual_members);
        } else {
            return User::all()->diff($actual_members);
        }
    }

    public function updatedSelected($value)
    {
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

    public function removeMember($id)
    {
        $member = ProjectMember::findOrFail($id);
        $member->delete();
        $this->project->refresh();
    }

    public function editPermissions($index, $values)
    {
        $this->editedMemberIndex = $index;
        $this->dispatchBrowserEvent('selectPicker', ['values' => $values]);
    }

    public function savePermission($user_id)
    {
        if (isset($user_id)) {
            $this->project->members()->updateExistingPivot($user_id, ['permission' => $this->selected]);
            $this->project->refresh();
            $this->editedMemberIndex = -1;
        }
    }

    public function ownerChangedHandler()
    {
        $this->getUsers();
    }

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function render()
    {
        return view('livewire.project.members', [
            'members' => $this->getMembers(),
            'users' => $this->getUsers()
        ]);
    }
}
