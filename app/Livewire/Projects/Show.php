<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Livewire\Component;
use Livewire\WithPagination;
use Tempest\Highlight\CommonMark\HighlightExtension;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\InlineTheme;

class Show extends Component
{
    use WithPagination;

    public $project;

    public $perPage = 10;

    public $assignee = null;

    public $status = null;

    public function mount($id)
    {
        $this->project = Project::findOrFail($id);
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        $environment = new Environment;

        $environment
            ->addExtension(new CommonMarkCoreExtension);

        $highlighter = (new Highlighter(new InlineTheme(__DIR__.'/../../../vendor/tempest/highlight/src/Themes/Css/github-dark-default.css')));
        $environment
            ->addExtension(new HighlightExtension($highlighter));

        $converter = new MarkdownConverter($environment);

        $installation = $converter->convert(
            Str::of(Storage::disk('markdown')->get('installation.md'))
                ->replace('=your-japoe-host', '='.asset(''))
                ->replace('=your-japoe-key', '='.$this->project->key)
        );

        return view('livewire.projects.show', [
            'project' => $this->project,
            'hasErrorLog' => $this->project->errorLogs()->count(),
            'installation' => $installation,
            'errorLogs' => $this->project
                ->errorLogs()
                ->select('group', DB::raw('count(id) as total'))
                ->with(['firstOccurrence', 'lastOccurrence.firstErrorLogFrame'])
                ->withCount(['occurrences'])
                ->when($this->status == 'resolved', function ($query) {
                    $query->whereHas('errorGroup', function ($query) {
                        $query->where('resolved_at', '!=', null);
                    });
                })
                ->when($this->status == 'unresolved', function ($query) {
                    $query->whereHas('errorGroup', function ($query) {
                        $query->where('resolved_at', null);
                    });
                })
                ->when($this->assignee, function ($query, $assigneeId) {
                    $query->whereHas('errorGroup', function ($query) use ($assigneeId) {
                        $query->where('assignee_id', $assigneeId);
                    });
                })
                ->groupBy('group')
                ->paginate($this->perPage),
        ]);
    }
}
