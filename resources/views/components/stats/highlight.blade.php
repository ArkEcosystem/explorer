@props(['icon', 'title', 'value'])

<x-general.card class="flex flex-shrink-0 items-center space-x-3">
    <div class="flex items-center space-x-3">
        <div class="border-2 border-theme-secondary-900 rounded-full p-2.5">
            <x-ark-icon :name="$icon" class="text-theme-secondary-900 dark:text-theme-secondary-600" />
        </div>

        <div class="flex flex-col">
            <h2 class="text-sm font-semibold text-theme-secondary-500 dark:text-theme-secondary-700 whitespace-nowrap">{{ $title }}</h2>
            <p class="font-semibold text-theme-secondary-700 dark:text-theme-secondary-200 whitespace-nowrap">{{ $value }}</p>
        </div>
    </div>
</x-general.card>
