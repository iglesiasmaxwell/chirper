<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex items-center space-x-5">
            <a href="{{ route('chirps.index') }}">
                <svg class="fill-gray-500 hover:fill-gray-" xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            </a>
            <p class="text-base">Search for '{{ $query }}'</p>
        </div>

        <p class="mt-6 text-gray-600 text-xl">Chirps</p>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @if ($chirps->isEmpty())
                <p class="p-6 space-x-2 text-center text-sm text-gray-700">There's no chirps found</p>
            @endif
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <a href="{{ route('chirps.show', $chirp) }}" class="text-gray-800">{{ $chirp->user->name }}</a>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('M j Y, g:i a') }}</small>
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-slate-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            <div>
                                @if ($chirp->user->is(auth()->user()))
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="mt-6 text-gray-600 text-xl">Users</p>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @if ($users->isEmpty())
                    <p class="p-6 space-x-2 text-center text-sm text-gray-700">There's no users found</p>
            @endif
            @foreach ($users as $user)
                <div class="p-6 flex space-x-2 items-center">
                    <svg class="fill-gray-600 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                                <a href="{{ route('profile.show', $user) }}" class="text-gray-800">{{ $user->name }}</a>
                                <small class="ml-2 text-sm text-gray-600">{{ $user->created_at->format('M j Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                {{ $users->links() }}
            </div>
            @endforeach
    </div>
    </div>
</x-app-layout>