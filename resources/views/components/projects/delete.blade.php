@props(['project', 'environments'])

<div>
    <div x-data="{
            tooltipVisible: false,
            tooltipText: 'Delete',
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

        <svg x-ref="content" wire:click="$toggle('confirmingDeletion')" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 size-5 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>

    </div>

    <x-confirmation-modal wire:model="confirmingDeletion">
        <x-slot name="title">
            Delete Project
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete your project? Once your project is deleted, all of its resources and data
            will be permanently deleted.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                Nevermind
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="delete({{$project->id}})" wire:loading.attr="disabled">
                Delete Project
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>