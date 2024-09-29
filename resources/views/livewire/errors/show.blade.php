<div>
    <x-slot name="header">
        <nav>
            <ol
                class="inline-flex items-center mb-3 space-x-3 text-sm text-neutral-500 [&_.active-breadcrumb]:text-neutral-500/80 sm:mb-0">
                <li class="flex items-center h-full"><a href="{{ route('dashboard') }}"
                        class="py-1 hover:text-neutral-900"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                            <path
                                d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                        </svg></a></li>
                <span class="mx-2 text-gray-400">/</span>
                <li><a href="{{ route('dashboard') }}"
                        class="inline-flex items-center py-1 font-normal hover:text-neutral-900 focus:outline-none">Projects</a>
                </li>
                <span class="mx-2 text-gray-400">/</span>
                <li><a href="{{ route('projects.show', $errorLog->project->id) }}"
                        class="inline-flex items-center py-1 font-normal hover:text-neutral-900 focus:outline-none">{{
                        $errorLog->project->name }}</a>
                </li>
                <span class="mx-2 text-gray-400">/</span>
                <li><a href="{{ route('errors.show', $errorLog->id) }}"
                        class="inline-flex items-center py-1 font-normal hover:text-neutral-900 focus:outline-none">{{
                        $errorLog->exception }}</a>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <x-error-logs.card :errorLog="$errorLog" :action="true" />

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div x-data="{ index: 0 }" class="grid gap-6 grid-cols-3 p-6">
                    <div class="col-span-1 space-y-2">
                        @foreach ($errorLog->lastOccurrence->errorLogFrames as $i => $frame)
                        <div x-on:click="index = {{ $i }}"
                            :class="{ 'border-l border-indigo-500 bg-gray-50': index == {{ $i }} }"
                            class="w-full py-2 px-2.5 cursor-pointer hover:bg-gray-100">
                            <p>{{ $frame->file }}:{{ $frame->line_number }}</p>
                            <p class="text-gray-600">{{ $frame->method }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-span-2">
                        @foreach ($errorLog->lastOccurrence->errorLogFrames as $i => $frame)
                        <div x-show="{{ $i }} == index">
                            <p class="font-medium">{{ $frame->file }}<span class="font-thin text-gray-600">:{{
                                    $frame->line_number }}</span></p>
                            <pre
                                class="bg-white text-sm border rounded border-natural-100 mt-2 whitespace-pre-wrap break-words px-4 py-2"><code class="bg-white">{!! str_replace($frame->line_number . ' -', '  ' . $frame->line_number, (new \Tempest\Highlight\Highlighter())->withGutter($frame->getFirstLine())->parse($frame->getSnippet(), 'php')) !!}</code></pre>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($errorLog->command)
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p class="text-2xl font-semibold">Command</p>
                <div class="mt-2">
                    <span>{{ implode(' ', $errorLog->command) }}</span>
                </div>
            </div>
            @else
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p class="text-2xl font-semibold">Request</p>
                <div class="mt-2">
                    <span>{{ $errorLog->method }}</span>
                    <span class="text-gray-500">/{{ $errorLog->path }}</span>
                </div>
                <div class="mt-2">
                    <span>Controller</span>
                    <span class="text-gray-500">{{ $errorLog->controller }}</span>
                </div>
                <p class="mt-4 font-semibold text-gray-900">Headers</p>
                <pre
                    class="border rounded-sm border-gray-100 mt-1 whitespace-pre-wrap break-words px-4 py-2"><code>{!! (new \Tempest\Highlight\Highlighter())->parse(json_encode($errorLog->headers, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), 'json') !!}</code></pre>

                <p class="mt-4 font-semibold text-gray-900">Query</p>
                <pre
                    class="border rounded-sm border-gray-100 mt-1 whitespace-pre-wrap break-words px-4 py-2"><code>{!! (new \Tempest\Highlight\Highlighter())->parse(json_encode($errorLog->query, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), 'json') !!}</code></pre>

                <p class="mt-4 font-semibold text-gray-900">Body</p>
                <pre
                    class="border rounded-sm border-gray-100 mt-1 whitespace-pre-wrap break-words px-4 py-2"><code>{!! (new \Tempest\Highlight\Highlighter())->parse(json_encode($errorLog->body, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), 'json') !!}</code></pre>
            </div>
            @endif
        </div>
    </div>
</div>