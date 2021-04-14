<?php

namespace App\Http\Livewire\Project;

use App\Models\ProjectMember;
use App\Models\User;
use Livewire\Component;

class Members extends Component
{
    public $project;
    public $editedMemberIndex = -1;

    protected $listeners = [
        'addUserAsMember' => 'addMember'
    ];

    private function getMembers()
    {
        return $this->project->members;
    }

    public function addMember($user_id)
    {
        if (isset($user_id)) {
            $user = User::find($user_id);
            $this->project->members()->save($user, ['permission' => json_encode(array('0' => 'all', '1'=>'add-task'))]);
            $this->project->refresh();
            $this->editedMemberIndex = -1;
        }
    }

    public function removeMember($id){
        $member = ProjectMember::findOrFail($id);
        $member->delete();
        $this->project->refresh();
    }

    public function editPermissions($index){
        $this->editedMemberIndex = $index;
    }

    public function mount()
    {
        $this->members = $this->getMembers();
    }

    public function render()
    {
        return view('livewire.project.members', [
            'members' => $this->getMembers(),
            'users' => User::all()->diff($this->getMembers())
        ]);
    }
}
