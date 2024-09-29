@props(['project'])

<div>
    <div x-data="{
            tooltipVisible: false,
            tooltipText: 'Api Key',
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

        <svg x-ref="content" wire:click="$toggle('showApiForm')" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-800 size-5 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
        </svg>
    </div>

    <x-dialog-modal wire:model="showApiForm" maxWidth="lg">
        <x-slot name="title">
            {{ $project->name }}
        </x-slot>

        <x-slot name="content">
            <div class="flex items-center">
                <x-label class=" mr-0.5" for="japoe_host" value="{{ __('JAPOE_HOST=') }}" />
                <div x-data="{
                    copyText: '{{ asset('') }}',
                    copyNotification: false,
                    copyToClipboard() {
                        navigator.clipboard.writeText(this.copyText);
                        this.copyNotification = true;
                        let that = this;
                        setTimeout(function(){
                            that.copyNotification = false;
                        }, 3000);
                    }
                }" class="relative z-20 flex items-center">
                    <p x-on:click="copyToClipboard();"
                        class="flex items-center justify-center w-auto h-8 px-3 py-1 text-sm bg-white border rounded-md cursor-pointer border-neutral-200/60 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none text-neutral-500 hover:text-neutral-600 group">
                        <span x-show="!copyNotification">{{ asset('') }}</span>
                        <svg x-show="!copyNotification" class="w-4 h-4 ml-1.5 stroke-current"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        <span x-show="copyNotification" class="tracking-tight text-green-500" x-cloak>Copied to
                            Clipboard</span>
                        <svg x-show="copyNotification" class="w-4 h-4 ml-1.5 text-green-500 stroke-current"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                        </svg>
                    </p>
                </div>
            </div>
            <div class="flex items-center mt-4">
                <x-label class=" mr-0.5" for="japoe_key" value="{{ __('JAPOE_KEY=') }}" />
                <div x-data="{
                    copyText: '{{$project->key}}',
                    copyNotification: false,
                    copyToClipboard() {
                        navigator.clipboard.writeText(this.copyText);
                        this.copyNotification = true;
                        let that = this;
                        setTimeout(function(){
                            that.copyNotification = false;
                        }, 3000);
                    }
                }" class="relative z-20 flex items-center">
                    <p x-on:click="copyToClipboard();"
                        class="flex items-center justify-center w-auto h-8 px-3 py-1 text-sm bg-white border rounded-md cursor-pointer border-neutral-200/60 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none text-neutral-500 hover:text-neutral-600 group">
                        <span x-show="!copyNotification">{{$project->key}}</span>
                        <svg x-show="!copyNotification" class="w-4 h-4 ml-1.5 stroke-current"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        <span x-show="copyNotification" class="tracking-tight text-green-500" x-cloak>Copied to
                            Clipboard</span>
                        <svg x-show="copyNotification" class="w-4 h-4 ml-1.5 text-green-500 stroke-current"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                        </svg>
                    </p>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button class="ml-2" wire:click="$toggle('showApiForm')">
                Close
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>