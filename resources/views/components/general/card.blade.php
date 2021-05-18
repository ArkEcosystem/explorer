@props(['icon', 'title', 'value'])

<div {{ $attributes->class('bg-white dark:bg-theme-secondary-900 rounded-lg px-8 py-4 flex items-center space-x-3') }}>
    <x-ark-icon :name="$icon" size="xl" class="text-theme-secondary-900 dark:text-theme-secondary-600" />

    <div class="flex flex-col">
        <h2 class="font-semibold text-sm text-theme-secondary-500 dark:text-theme-secondary-700">{{ $title }}</h2>
        <p class="font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $value }}</p>
    </div>
</div>
