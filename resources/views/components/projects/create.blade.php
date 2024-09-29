@props(['environments'])

<div>
    <div class="min-h-[168px] cursor-pointer bg-white overflow-hidden shadow-xl sm:rounded-lg flex items-center justify-center"
        wire:click="openCreateForm">
        <div class="p-6 text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 text-indigo-600 mx-auto">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <p>Create new project</p>
        </div>
    </div>

    <x-dialog-modal wire:model="showCreateForm" maxWidth="md">
        <x-slot name="title">
            Create Project
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
            <x-secondary-button wire:click="$toggle('showCreateForm')">
                Cancel
            </x-secondary-button>

            <x-button class="ml-2" wire:click="create">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>