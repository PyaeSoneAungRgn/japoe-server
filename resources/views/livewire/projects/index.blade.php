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
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach ($projects as $project)
                <x-projects.card :project="$project" :environments="$environments" />
                @endforeach
                <x-projects.create :environments="$environments" />
            </div>
        </div>
    </div>
</div>