@props(['errorLog'])

<div>
    <div x-data="{
            tooltipVisible: false,
            tooltipText: '{{$errorLog->errorGroup?->resolved_at ? 'Unresolve' : 'Resolve'}}',
            tooltipArrow: true,
            tooltipPosition: 'top',
        }"
        x-init="$refs.content.addEventListener('mouseenter', () => { tooltipVisible = true; }); $refs.content.addEventListener('mouseleave', () => { tooltipVisible = false; });"
        class="relative">

        <div x-ref="tooltip" x-show="tooltipVisible"
            :class="{ 'top-0 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full' : tooltipPosition == 'top', 'top-1/2 -translate-y-1/2 -ml-0.5 left-0 -translate-x-full' : tooltipPosition == 'left', 'bottom-0 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full' : tooltipPosition == 'bottom', 'top-1/2 -translate-y-1/2 -mr-0.5 right-0 translate-x-full' : tooltipPosition == 'right' }"
            class="absolute w-auto text-sm" x-cloak>
            <div x-show="tooltipVisible" x-transition
                class="relative px-2 py-1 text-white bg-black rounded bg-opacity-90">
                <p x-text="tooltipText" class="flex-shrink-0 block text-xs whitespace-nowrap"></p>
                <div x-ref="tooltipArrow" x-show="tooltipArrow"
                    :class="{ 'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full' : tooltipPosition == 'top', 'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full' : tooltipPosition == 'left', 'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full' : tooltipPosition == 'bottom', 'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full' : tooltipPosition == 'right' }"
                    class="absolute inline-flex items-center justify-center overflow-hidden">
                    <div :class="{ 'origin-top-left -rotate-45' : tooltipPosition == 'top', 'origin-top-left rotate-45' : tooltipPosition == 'left', 'origin-bottom-left rotate-45' : tooltipPosition == 'bottom', 'origin-top-right -rotate-45' : tooltipPosition == 'right' }"
                        class="w-1.5 h-1.5 transform bg-black bg-opacity-90"></div>
                </div>
            </div>
        </div>

        <svg x-ref="content" wire:click="$toggle('showResolveForm')" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-indigo-600 size-5 cursor-pointer">
            @if($errorLog->errorGroup?->resolved_at)
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 0 1-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 0 0 2.248-2.354M12 12.75a2.25 2.25 0 0 1-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 0 0-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 0 1 .4-2.253M12 8.25a2.25 2.25 0 0 0-2.248 2.146M12 8.25a2.25 2.25 0 0 1 2.248 2.146M8.683 5a6.032 6.032 0 0 1-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0 1 15.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 0 0-.575-1.752M4.921 6a24.048 24.048 0 0 0-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 0 1-5.223 1.082" />
            @else
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884
                    4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1
                    1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276
                    3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
            @endif
        </svg>
    </div>

    <x-dialog-modal wire:model="showResolveForm" maxWidth="md">
        <x-slot name="title">
            {{$errorLog->errorGroup?->resolved_at ? 'Unresolve' : 'Resolve'}}
        </x-slot>

        <x-slot name="content">
            <div>
                <x-label for="comment" value="{{ __('Comment') }}" />
                <textarea wire:model="comment" name="comment" id="comment"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
                <x-input-error for="comment" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showResolveForm')">
                Cancel
            </x-secondary-button>

            @if($errorLog->errorGroup?->resolved_at)
            <x-danger-button class="ml-2" wire:click="unresolve">
                Unresolve
            </x-danger-button>
            @else
            <x-button class="ml-2" wire:click="resolve">
                Resolve
            </x-button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>