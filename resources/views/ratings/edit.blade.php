<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('ratings.update', $rating) }}">
            @csrf
            @method('patch')
            <label for="artist" class="mt-4 text-lg text-gray-800 dark:text-gray-200">Artist</label>
            <input type='text' id="artist" name="artist" value="{{ old('artist', $rating->artist) }}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <x-input-error :messages="$errors->get('artist')" class="mt-2"/>
            <label for="title" class="mt-4 text-lg text-gray-800 dark:text-gray-200">Title</label>
            <input type='text' id="title" name="title" value="{{ old('title', $rating->title) }}"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <x-input-error :messages="$errors->get('title')" class="mt-2"/>
            <label for="stars" class="mt-4 text-lg text-gray-800 dark:text-gray-200">Rating</label>
            <input type='number' id="stars" name="stars" value="{{ old('stars', $rating->stars) }}"
                   class="block w-20 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <p class="text-lg text-gray-800 dark:text-gray-200">/ 5</p>
            <x-input-error :messages="$errors->get('stars')" class="mt-2"/>
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('ratings.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
