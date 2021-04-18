<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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

    public function attachFile($user, $task)
    {
        if ((isset($task->responsible) && $user->id === $task->responsible->id) ||
            $user->id === $task->creator->id ||
            $task->project->findIfMemberHasPermission($user->id, 'attach-file') ||
            $task->project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }

    public function removeFile($user, $task)
    {
        if ((isset($task->responsible) && $user->id === $task->responsible->id) ||
            $user->id === $task->creator->id ||
            $task->project->findIfMemberHasPermission($user->id, 'remove-file') ||
            $task->project->findIfMemberHasPermission($user->id, 'all')
        )
            return true;
        return false;
    }
}
