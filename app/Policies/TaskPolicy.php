<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || $task->project->owner_id === $user->id
            || $task->project->members->contains($user->id);
    }

    public function create(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('crear tarea') && (
                $project->owner_id === $user->id
                || $project->members->contains($user->id)
            ));
    }

    public function update(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || $task->project->owner_id === $user->id
            || ($user->can('editar tarea')
                && $task->assignee_id === $user->id);
    }

    public function assign(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || ($user->can('asignar tarea')
                && $task->project->owner_id === $user->id);
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole('admin')
            || ($user->can('eliminar tarea')
                && $task->project->owner_id === $user->id);
    }
}