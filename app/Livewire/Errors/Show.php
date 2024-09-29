<?php

namespace App\Livewire\Errors;

use App\Models\ErrorLog;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Show extends Component
{
    public $errorLog;

    public $confirmingDeletion = false;

    public $showAssignForm = false;

    public $showResolveForm = false;

    #[Validate('nullable')]
    public $assigneeId;

    #[Validate('nullable')]
    public $comment;

    public function unresolve()
    {
        $this->validateOnly('comment');

        $this->authorize('update', $this->errorLog);

        $this->errorLog
            ->errorGroup()
            ->updateOrCreate(
                [
                    'group' => $this->errorLog->group,
                ],
                [
                    'resolve_by' => null,
                    'resolved_at' => null,
                    'comment' => $this->comment,
                ]
            );

        $this->showResolveForm = false;
    }

    public function resolve()
    {
        $this->validateOnly('comment');

        $this->authorize('update', $this->errorLog);

        $this->errorLog
            ->errorGroup()
            ->updateOrCreate(
                [
                    'group' => $this->errorLog->group,
                ],
                [
                    'resolve_by' => auth()->user()->id,
                    'resolved_at' => now($this->errorLog->project->timezone),
                    'comment' => $this->comment,
                ]
            );

        $this->showResolveForm = false;
    }

    public function updateAssignee()
    {
        $this->validateOnly('assigneeId');

        $this->authorize('update', $this->errorLog);

        $this->errorLog
            ->errorGroup()
            ->updateOrCreate(
                [
                    'group' => $this->errorLog->group,
                ],
                [
                    'assignee_id' => $this->assigneeId,
                ]
            );

        $this->showAssignForm = false;
    }

    public function delete($id)
    {
        $errorLog = ErrorLog::query()
            ->findOrFail($id);

        $this->authorize('delete', $this->errorLog);

        $errorLog->errorGroup()->delete();

        $errorLog->delete();

        return redirect()->route('projects.show', $errorLog->project->id);
    }

    public function mount($id)
    {
        $this->errorLog = ErrorLog::with([
            'project',
            'firstOccurrence',
            'lastOccurrence.firstErrorLogFrame',
            'lastOccurrence.errorLogFrames',
            'errorGroup.resolvedBy',
        ])
            ->withCount(['occurrences'])
            ->findOrFail($id);

        $this->authorize('view', $this->errorLog);

        $this->assigneeId = $this->errorLog->errorGroup?->assignee_id;
        $this->comment = $this->errorLog->errorGroup?->comment;
    }

    public function render()
    {
        return view('livewire.errors.show');
    }
}
