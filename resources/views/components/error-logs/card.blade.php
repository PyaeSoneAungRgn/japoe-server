@props(['errorLog', 'action' => false])

<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between">
            <div class="max-w-[70%]">
                <span class="bg-red-100 text-red-800 px-2.5 py-2 rounded-full">{{
                    $errorLog->lastOccurrence->exception }}</span>
                <a href="{{ route('errors.show', $errorLog->lastOccurrence->id) }}"
                    class="mt-2 block text-2xl font-semibold">{{
                    $errorLog->lastOccurrence->message }}</a>
                <p class="mt-6 text-sm">{{ $errorLog->lastOccurrence->firstErrorLogFrame->file }}:<strong>{{
                        $errorLog->lastOccurrence->firstErrorLogFrame->line_number }}</strong></p>
            </div>
            <div class="text-right">
                @if($errorLog->lastOccurrence->command)
                <p style="margin-left: auto; margin-right: 0px"
                    class="w-fit bg-gray-200 text-gray-900 px-2.5 py-2 rounded-full text-sm">{{
                    implode(' ',
                    $errorLog->lastOccurrence->command) }}</p>
                @else
                <p style="margin-left: auto; margin-right: 0px"
                    class="w-fit bg-gray-200 text-gray-900 px-2.5 py-2 rounded-full text-sm">{{
                    $errorLog->lastOccurrence->method }}
                    {{ $errorLog->lastOccurrence->host }}</p>
                @endif
                <p class="mt-4 text-right text-sm text-gray-700">
                    Occurrences: <strong>{{ $errorLog->occurrences_count
                        }}</strong>
                </p>
                <p class="mt-1 text-right text-sm text-gray-700">
                    First Occurred: <strong>{{ $errorLog->firstOccurrence->created_at->toDateTimeString()
                        }}</strong>
                </p>
                <p class="mt-1 text-right text-sm text-gray-700">
                    Last Occurred: <strong>{{ $errorLog->lastOccurrence->created_at->toDateTimeString()
                        }}</strong>
                </p>
            </div>
        </div>
        @if($action)
        <div class="border-t mt-2">
            <div class="flex justify-between mt-2 space-x-4">
                <div>
                    @if($errorLog->errorGroup?->resolved_at) Resolved by <span
                        class="text-indigo-600">{{$errorLog->errorGroup?->resolvedBy?->name}}</span>
                    @endif
                </div>
                <div class="flex space-x-4">
                    @can('update', $errorLog)
                    <x-error-logs.assign :errorLog="$errorLog" />
                    @endcan
                    @can('update', $errorLog)
                    <x-error-logs.resolve :errorLog="$errorLog" />
                    @endcan
                    @can('delete', $errorLog)
                    <x-error-logs.delete :errorLog="$errorLog" />
                    @endcan
                </div>
            </div>
        </div>
        @else
        @if($errorLog->errorGroup?->resolved_at)
        <div class="border-t mt-2">
            <div class="mt-2">
                Resolved by <span class="text-indigo-600">{{$errorLog->errorGroup?->resolvedBy?->name}}</span>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>