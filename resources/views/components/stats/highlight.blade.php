@props(['icon', 'title', 'value'])

<x-general.card class="flex items-center flex-shrink-0 min-w-80 sm:min-w-60 space-x-3">
    <x-ark-icon :name="$icon" size="xl" class="text-theme-secondary-900 dark:text-theme-secondary-600" />

    <div class="flex flex-col">
        <h2 class="font-semibold text-sm text-theme-secondary-500 dark:text-theme-secondary-700">{{ $title }}</h2>
        <p class="font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $value }}</p>
    </div>
</x-general.card>
