<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function addSubproject($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'add-subproject') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function editProject($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'edit-project') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function deleteProject($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'delete-project') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function addTask($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'add-task') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function editTask($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'edit-task') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function addSubtask($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'add-subtask') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function deleteTask($user, $project)
    {
        if ((isset($project->owner) && $user->id === $project->owner->id) ||
            $user->id === $project->creator->id ||
            $project->findIfMemberHasPermission($user->id, 'delete-task') ||
            $project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }
}
