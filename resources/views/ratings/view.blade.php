<x-app-layout>
    <div class="mt-4 max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-white dark:bg-gray-600 rounded-lg">
        <h2 class="text-lg text-gray-800 dark:text-gray-200">User</h2>
        <p class="text-gray-800 dark:text-gray-200">
            {{$rating->user->name}}</p>
        <h2 class="mt-4 text-lg text-gray-800 dark:text-gray-200">Artist</h2>
        <p class="text-gray-800 dark:text-gray-200">
            {{$rating->artist}}</p>
        <h2 class="mt-4 text-lg text-gray-800 dark:text-gray-200">Title</h2>
        <p class="text-gray-800 dark:text-gray-200">{{ $rating->title }}</p>
        <h2 class="mt-4 text-lg text-gray-800 dark:text-gray-200">Rating</h2>
        <p class="text-lg text-gray-800 dark:text-gray-200">{{ $rating->stars }} / 5</p>
        <small class="text-sm text-gray-800 dark:text-gray-200">{{ $rating->created_at->format('j M Y, g:i a') }}</small>
        @unless ($rating->created_at->eq($rating->updated_at))
            <small class="text-sm text-gray-800 dark:text-gray-200"> &middot; {{ __('edited') }}</small>
        @endunless
        <div class="mt-4 space-x-2">
            <x-secondary-button onclick="location.href='{{ route('ratings.index') }}'">{{ __('Back') }}</x-secondary-button>
        </div>
    </div>
</x-app-layout>
