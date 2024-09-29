@props(['errorLog'])

<div>
    <div x-data="{
            tooltipVisible: false,
            tooltipText: 'Assign',
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

        <svg x-ref="content" wire:click="$toggle('showAssignForm')" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="currentColor size-5 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
        </svg>
    </div>

    <x-dialog-modal wire:model="showAssignForm" maxWidth="md">
        <x-slot name="title">
            Assign
        </x-slot>

        <x-slot name="content">
            <div>
                <x-label for="assigneeId" value="{{ __('Assignee') }}" />
                <select wire:model="assigneeId" name="assigneeId" id="assigneeId"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option selected>Please choose</option>
                    @foreach (auth()->user()->currentTeam->allUsers() as $user)
                    <option value="{{ $user->id }}">
                        {{ auth()->user()->id == $user->id ? 'Me' : $user->name }}
                    </option>
                    @endforeach
                </select>
                <x-input-error for="assigneeId" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showAssignForm')">
                Cancel
            </x-secondary-button>

            <x-button class="ml-2" wire:click="updateAssignee">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>