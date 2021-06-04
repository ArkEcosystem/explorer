@props([
    'id',
    'mainTitle',
    'mainValue',
    'secondaryTitle',
    'secondaryValue',
    'tertiaryTitle' => null,
    'tertiaryValue' => null,
    'chart' => null,
    'chartTheme' => 'grey',
    'options',
    'model',
    'selected',
])

<x-general.card with-border class="flex flex-col gap-6 md:flex-row xl:flex-col">
    <div class="md:w-1/2 xl:w-full">
        <h2 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-900 dark:text-theme-secondary-200">{{ $mainTitle }}</h2>
        <x-ark-rich-select
            wire:model="{{ $model }}"
            wrapper-class="hidden relative left-0 mt-3 md:inline-block xl:hidden"
            dropdown-class="right-0 mt-1 origin-top-right"
            button-class="block text-sm font-semibold text-left bg-transparent text-theme-secondary-700 dark:text-theme-secondary-200"
            :initial-value="$selected"
            :placeholder="$selected"
            :options="$options"
        />
        <p class="mt-3 text-lg font-bold sm:text-2xl text-theme-secondary-900 dark:text-theme-secondary-200">{{ $mainValue }}</p>
    </div>

    <div class="border-t border-theme-secondary-300 dark:border-theme-secondary-800 pt-6 md:pt-0 md:border-t-0 xl:pt-6 xl:border-t row-span-2 sm:row-span-1 flex gap-5 flex-col sm:flex-row sm:items-end md:w-1/2 lg:justify-end xl:w-full">
        <div class="sm:w-1/3 md:w-1/2">
            <x-ark-rich-select
                wire:model="{{ $model }}"
                wrapper-class="relative left-0 md:hidden xl:inline-block"
                dropdown-class="right-0 mt-1 origin-top-right"
                button-class="block text-sm font-semibold text-left bg-transparent text-theme-secondary-700 dark:text-theme-secondary-200"
                :initial-value="$selected"
                :placeholder="$selected"
                :options="$options"
            />
            <h3 class="mt-4 mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $secondaryTitle }}</h3>
            <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $secondaryValue }}</p>
        </div>

        @if($chart)
            <div class="md:w-1/2 flex flex-1 justify-end">
                <x-chart
                    class="w-full h-auto"
                    id="stats-insight-{{ $id }}"
                    :data="$chart->get('datasets')"
                    :labels="$chart->get('labels')"
                    :theme="$chartTheme"
                    width="200"
                    height="50"
                />
            </div>
        @else
            <div class="md:w-1/2 border-theme-secondary-300 dark:border-theme-secondary-800 sm:border-l sm:pl-6 sm:transform sm:-translate-x-6 md:-translate-x-8 lg:-translate-x-6">
                <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $tertiaryTitle }}</h3>
                <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $tertiaryValue }}</p>
            </div>
        @endif
    </div>

</x-general.card>
