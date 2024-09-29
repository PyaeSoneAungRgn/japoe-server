<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Actions\UpdateTeamMemberRole;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Role;
use Livewire\Component;

class TeamMemberManager extends Component
{
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * Indicates if a user's role is currently being managed.
     *
     * @var bool
     */
    public $currentlyManagingRole = false;

    /**
     * The user that is having their role managed.
     *
     * @var mixed
     */
    public $managingRoleFor;

    /**
     * The current role for the user that is having their role managed.
     *
     * @var string
     */
    public $currentRole;

    /**
     * Indicates if the application is confirming if a user wishes to leave the current team.
     *
     * @var bool
     */
    public $confirmingLeavingTeam = false;

    /**
     * Indicates if the application is confirming if a team member should be removed.
     *
     * @var bool
     */
    public $confirmingTeamMemberRemoval = false;

    /**
     * The ID of the team member being removed.
     *
     * @var int|null
     */
    public $teamMemberIdBeingRemoved = null;

    /**
     * The "add team member" form state.
     *
     * @var array
     */
    public $addTeamMemberForm = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => null,
    ];

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    /**
     * Add a new team member to a team.
     *
     * @return void
     */
    public function addTeamMember()
    {
        $this->resetErrorBag();

        app(AddsTeamMembers::class)->add(
            $this->user,
            $this->team,
            $this->addTeamMemberForm['name'],
            $this->addTeamMemberForm['email'],
            $this->addTeamMemberForm['password'],
            $this->addTeamMemberForm['role']
        );

        $this->addTeamMemberForm = [
            'name' => '',
            'email' => '',
            'password' => '',
            'role' => null,
        ];

        $this->team = $this->team->fresh();

        $this->dispatch('saved');
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            $model = Jetstream::teamInvitationModel();

            $model::whereKey($invitationId)->delete();
        }

        $this->team = $this->team->fresh();
    }

    /**
     * Allow the given user's role to be managed.
     *
     * @param  int  $userId
     * @return void
     */
    public function manageRole($userId)
    {
        $this->currentlyManagingRole = true;
        $this->managingRoleFor = Jetstream::findUserByIdOrFail($userId);
        $this->currentRole = $this->managingRoleFor->teamRole($this->team)->key;
    }

    /**
     * Save the role for the user being managed.
     *
     * @return void
     */
    public function updateRole(UpdateTeamMemberRole $updater)
    {
        $updater->update(
            $this->user,
            $this->team,
            $this->managingRoleFor->id,
            $this->currentRole
        );

        $this->team = $this->team->fresh();

        $this->stopManagingRole();
    }

    /**
     * Stop managing the role of a given user.
     *
     * @return void
     */
    public function stopManagingRole()
    {
        $this->currentlyManagingRole = false;
    }

    /**
     * Remove the currently authenticated user from the team.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveTeam(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $this->user
        );

        $this->confirmingLeavingTeam = false;

        $this->team = $this->team->fresh();

        return redirect(config('fortify.home'));
    }

    /**
     * Confirm that the given team member should be removed.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmTeamMemberRemoval($userId)
    {
        $this->confirmingTeamMemberRemoval = true;

        $this->teamMemberIdBeingRemoved = $userId;
    }

    /**
     * Remove a team member from the team.
     *
     * @return void
     */
    public function removeTeamMember(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $user = Jetstream::findUserByIdOrFail($this->teamMemberIdBeingRemoved)
        );

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->team = $this->team->fresh();
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Get the available team member roles.
     *
     * @return array
     */
    public function getRolesProperty()
    {
        return collect(Jetstream::$roles)->transform(function ($role) {
            return with($role->jsonSerialize(), function ($data) {
                return (new Role(
                    $data['key'],
                    $data['name'],
                    $data['permissions']
                ))->description($data['description']);
            });
        })->values()->all();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.team-member-manager');
    }
}
