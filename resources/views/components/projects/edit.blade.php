@props(['project', 'environments'])

<div>
    <div x-data="{
            tooltipVisible: false,
            tooltipText: 'Edit',
            tooltipArrow: true,
            tooltipPosition: 'bottom',
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

        <svg x-ref="content" wire:click="openEditForm({{$project->id}})" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-netural-800 size-5 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
        </svg>
    </div>

    <x-dialog-modal wire:model="showEditForm" maxWidth="md">
        <x-slot name="title">
            Edit Project
        </x-slot>

        <x-slot name="content">
            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input wire:model="name" id="name" type="text" class="mt-1 block w-full" autofocus />
                <x-input-error for="name" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="environment" value="{{ __('Environment') }}" />
                <select wire:model="environment" name="environment" id="environment"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    @foreach ($environments as $environment)
                    <option value="{{ $environment->value }}">{{ $environment->value }}</option>
                    @endforeach
                </select>
                <x-input-error for="environment" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showEditForm')">
                Cancel
            </x-secondary-button>

            <x-button class="ml-2" wire:click="update({{ $project->id }})">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>