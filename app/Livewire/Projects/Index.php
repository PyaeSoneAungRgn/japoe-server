<?php

namespace App\Livewire\Projects;

use App\Enums\ProjectEnvironmentEnum;
use App\Models\Project;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    public $projects;

    public $showCreateForm = false;

    public $showEditForm = false;

    public $showApiForm = false;

    public $confirmingDeletion = false;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $environment = 'development';

    public function resetForm()
    {
        $this->name = '';
        $this->environment = 'development';
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->showEditForm = false;
        $this->confirmingDeletion = false;
        $this->showCreateForm = true;
    }

    public function openEditForm($id)
    {
        $project = Project::findOrFail($id);

        $this->name = $project->name;
        $this->environment = $project->environment;

        $this->showCreateForm = false;
        $this->confirmingDeletion = false;
        $this->showEditForm = true;
    }

    public function update($id)
    {
        $this->validate();

        $project = Project::where('team_id', auth()->user()->currentTeam->id)
            ->findOrFail($id);
        $this->authorize('update', $project);

        $project->update($this->only(['name', 'environment']));

        $this->projects = $this->getProjects();

        $this->showEditForm = false;

        $this->resetForm();
    }

    public function delete($id)
    {
        $project = Project::where('team_id', auth()->user()->currentTeam->id)
            ->findOrFail($id);
        $this->authorize('delete', $project);
        $project->delete();

        $this->projects = $this->getProjects();

        $this->confirmingDeletion = false;
    }

    public function create()
    {
        $this->validate();

        Project::create([
            ...$this->only(['name', 'environment']),
            'team_id' => auth()->user()->currentTeam->id,
            'key' => Str::uuid(),
        ]);

        $this->projects = $this->getProjects();

        $this->showCreateForm = false;

        $this->resetForm();
    }

    public function hydrate()
    {
        $this->projects->loadCount('errorLogs');
    }

    public function mount()
    {
        $this->projects = $this->getProjects();
    }

    private function getProjects()
    {
        return Project::with(['lastErrorLog'])
            ->withCount(['errorLogs'])
            ->where('team_id', auth()->user()->currentTeam->id)
            ->get();
    }

    public function render()
    {
        return view('livewire.projects.index', [
            'projects' => $this->projects,
            'environments' => ProjectEnvironmentEnum::cases(),
        ]);
    }
}
