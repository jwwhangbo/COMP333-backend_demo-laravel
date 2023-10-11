<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('ratings.store') }}">
            @csrf
            <label for="artist" class="mt-4 text-lg text-gray-800 dark:text-gray-200">Artist</label>
            <input type='text' id="artist" name="artist" class="block w-full border-gray-300 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <x-input-error :messages="$errors->get('artist')" class="mt-2"/>
            <label for="title" class="mt-4 text-lg text-gray-800 dark:text-gray-200">Title</label>
            <input type='text' id="title" name="title" class="block w-full border-gray-300 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <x-input-error :messages="$errors->get('title')" class="mt-2"/>
            <label for="stars" class="mt-4 text-lg text-gray-800 dark:text-gray-200">Rating</label>
            <input type='number' id="stars" name="stars" class="block w-20 border-gray-300 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <p class="text-lg text-gray-800 dark:text-gray-200">/ 5</p>
            <x-input-error :messages="$errors->get('stars')" class="mt-2"/>
            <x-primary-button class="mt-4">{{ __('Submit') }}</x-primary-button>
        </form>

        <div class="mt-6 bg-white dark:bg-gray-600 border-b border-gray-100 dark:border-gray-700 shadow-sm rounded-lg">
            <table class="table-auto border-separate w-full text-base dark:text-gray-300">
                <thead class="text-lg">
                    <tr>
                        <th>User</th>
                        <th>Artist</th>
                        <th>Title</th>
                        <th>Rating</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($ratings as $rating)
                        <tr>
                            <th>{{ $rating->user->name }}</th>
                            <th>{{ $rating->artist }}</th>
                            <th>{{ $rating->title  }}</th>
                            <th>{{ $rating->stars }}</th>
                            <th class="border-none">
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('ratings.show', $rating)">
                                            {{ __('View') }}
                                        </x-dropdown-link>
                                        @if($rating->user->is(auth()->user()))
                                            <x-dropdown-link :href="route('ratings.edit', $rating)">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>

                                            <form id="{{ $rating->id }}"x-data @confirm.window="document.getElementById('{{ $rating->id }}').submit()" method="POST" action="{{ route('ratings.destroy', $rating) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link x-data x-on:click.prevent="$dispatch('open-modal', 'confirm-rating-delete')">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        @endif
                                    </x-slot>
                                </x-dropdown>
                            </th>
                        </tr>

                    @endforeach
                </tbody>
            </table>
            <x-modal name="confirm-rating-delete" focusable>
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete this rating?') }}
                    </h2>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3" x-on:click="$dispatch('confirm')">
                            {{ __('Delete') }}
                        </x-danger-button>
                    </div>
                </div>
            </x-modal>
        </div>
    </div>
</x-app-layout>
