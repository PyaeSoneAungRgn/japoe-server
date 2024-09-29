<?php

namespace App\Actions;

use App\Models\Project;
use Illuminate\Support\Str;

class CaptureErrorAction
{
    public function __construct(
        private readonly Project $model
    ) {}

    public function handle(array $payload): void
    {
        $project = $this->model
            ->where('key', data_get($payload, 'project_key'))
            ->firstOrFail();

        config(['app.timezone' => $project->timezone]);

        $group = data_get($payload, 'command')
            ? implode(' ', data_get($payload, 'command'))
            : data_get($payload, 'controller');

        $group = Str::of($group)->slug()->substr(0, 250);

        $errorLog = $project->errorLogs()
            ->create([
                'exception' => data_get($payload, 'exception'),
                'message' => data_get($payload, 'message'),
                'group' => $group,
                'host' => data_get($payload, 'host'),
                'method' => data_get($payload, 'method'),
                'path' => data_get($payload, 'path'),
                'headers' => data_get($payload, 'headers'),
                'query' => data_get($payload, 'query'),
                'body' => data_get($payload, 'body'),
                'timezone' => data_get($payload, 'timezone'),
                'controller' => data_get($payload, 'controller'),
                'command' => data_get($payload, 'command'),
                'created_at' => now(),
            ]);

        $errorLog->errorLogFrames()
            ->createMany(data_get($payload, 'frames'));

        $errorGroup = $errorLog->errorGroup()->where('group', $group)->first();
        if ($errorGroup) {
            $errorGroup->update([
                'comment' => null,
                'resolve_by' => null,
                'resolved_at' => null,
            ]);
        }
    }
}
