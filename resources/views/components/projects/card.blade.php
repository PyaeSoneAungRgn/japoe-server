@props(['environments', 'project'])

<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex items-center justify-between">
                <span class="rounded-full px-2.5 py-0.5 text-white text-xs font-semibold bg-black">
                    {{ $project->environment }}
                </span>
                <div class="flex items-center space-x-3">
                    @can('view', $project)
                    <x-projects.key :project="$project" />
                    @endcan
                    @can('update', $project)
                    <x-projects.edit :project="$project" :environments="$environments" />
                    @endcan
                    @can('delete', $project)
                    <x-projects.delete :project="$project" :environments="$environments" />
                    @endcan
                </div>
            </div>
            <a href="{{ route('projects.show', $project->id) }}" class="text-xl font-bold text-indigo-600">{{
                $project->name }}</a>
            <p class="mt-6 font-thin">Latest: <span class="font-medium">{{
                    $project->lastErrorLog?->created_at->diffForHumans() ?: '-' }}</span></p>
            <p class="font-thin">Total: <span class="font-medium">{{ $project->error_logs_count }}
                    Occurrences</span>
            </p>
        </div>
    </div>
</div>