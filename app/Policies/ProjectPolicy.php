<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('ver proyecto');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || $project->owner_id === $user->id
            || $project->members->contains($user->id);
    }

    public function create(User $user): bool
    {
        return $user->can('crear proyecto');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('editar proyecto')
                && $project->owner_id === $user->id);
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('eliminar proyecto')
                && $project->owner_id === $user->id);
    }

    public function manageMembers(User $user, Project $project): bool
    {
        return $user->hasRole('admin')
            || ($user->can('gestionar miembros')
                && $project->owner_id === $user->id);
    }
}