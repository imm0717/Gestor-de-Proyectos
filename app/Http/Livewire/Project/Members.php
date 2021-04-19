<?php

namespace App\Http\Livewire\Project;

use App\Models\Permission;
use App\Models\ProjectMember;
use App\Models\User;
use Livewire\Component;
use App\Traits\WithLogs;
use Illuminate\Database\QueryException;

class Members extends Component
{
    use WithLogs;

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
            try {
                $user = User::find($user_id);
                $this->project->members()->save($user, ['permission' => json_encode(array('0' => 'all'))]);
                $this->project->refresh();
                $this->editedMemberIndex = -1;

                $log_message = "Inserción de $user->name como miembro del Proyecto";
                $this->logActivity(WithLogs::$create, $log_message, ['model' => Project::class, 'id' => $this->project->id]);
            } catch (QueryException $e) {
                $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Project::class, 'id' => $this->project->id]);
            }
        }
    }

    public function removeMember($id)
    {
        try {
            $member = ProjectMember::findOrFail($id);
            $member->delete();
            $this->project->refresh();

            $log_message = "Eliminación de $member->name como miembro del Proyecto";
            $this->logActivity(WithLogs::$delete, $log_message, ['model' => Project::class, 'id' => $this->project->id]);
        } catch (QueryException $e) {
            $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Project::class, 'id' => $this->project->id]);
        }
    }

    public function editPermissions($index, $values)
    {
        $this->editedMemberIndex = $index;
        $this->dispatchBrowserEvent('selectPicker', ['values' => $values]);
    }

    public function savePermission($user_id)
    {
        if (isset($user_id)) {

            try {
                $this->project->members()->updateExistingPivot($user_id, ['permission' => $this->selected]);
                $this->project->refresh();
                $this->editedMemberIndex = -1;

                $user = User::find($user_id);
                $log_message = "Edición de privilegios en el proyecto del usuario $user->name ";
                $this->logActivity(WithLogs::$delete, $log_message, ['model' => Project::class, 'id' => $this->project->id]);
            } catch (QueryException $e) {
                
                $this->logActivity(WithLogs::$error, $e->getMessage(), ['model' => Project::class, 'id' => $this->project->id]);
            }
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
