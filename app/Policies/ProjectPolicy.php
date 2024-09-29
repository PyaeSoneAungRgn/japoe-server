<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        $team = $project->team;

        return $user->belongsToTeam($team) &&
           $user->hasTeamPermission($team, 'project:read') &&
           $user->tokenCan('project:read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        $team = $project->team;

        return $user->belongsToTeam($team) &&
           $user->hasTeamPermission($team, 'project:update') &&
           $user->tokenCan('project:update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        $team = $project->team;

        return $user->belongsToTeam($team) &&
           $user->hasTeamPermission($team, 'project:delete') &&
           $user->tokenCan('project:delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }
}
