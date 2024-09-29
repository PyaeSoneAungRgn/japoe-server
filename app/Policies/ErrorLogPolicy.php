<?php

namespace App\Policies;

use App\Models\ErrorLog;
use App\Models\User;

class ErrorLogPolicy
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
    public function view(User $user, ErrorLog $errorLog): bool
    {
        $team = $errorLog->project->team;

        return $user->belongsToTeam($team) &&
           $user->hasTeamPermission($team, 'error-log:read') &&
           $user->tokenCan('error-log:read');
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
    public function update(User $user, ErrorLog $errorLog): bool
    {
        $team = $errorLog->project->team;

        return $user->belongsToTeam($team) &&
           $user->hasTeamPermission($team, 'error-log:update') &&
           $user->tokenCan('error-log:update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ErrorLog $errorLog): bool
    {
        $team = $errorLog->project->team;

        return $user->belongsToTeam($team) &&
           $user->hasTeamPermission($team, 'error-log:delete') &&
           $user->tokenCan('error-log:delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ErrorLog $errorLog): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ErrorLog $errorLog): bool
    {
        //
    }
}
