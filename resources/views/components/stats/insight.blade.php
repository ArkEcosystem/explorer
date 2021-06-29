@props([
    'id',
    'mainTitle',
    'mainValue',
    'secondaryTitle',
    'secondaryValue',
    'secondaryTooltip' => null,
    'tertiaryTitle' => null,
    'tertiaryValue' => null,
    'chart' => null,
    'chartTheme' => 'grey',
    'options',
    'model',
    'selected',
])

<x-general.card with-border class="flex flex-col gap-6 md:flex-row xl:flex-col xl:h-full">
    <div class="md:w-1/2 xl:w-full">
        <h2 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-900 dark:text-theme-secondary-200">{{ $mainTitle }}</h2>
        <x-ark-rich-select
            wire:model="{{ $model }}"
            wrapper-class="hidden relative left-0 mt-3 md:inline-block xl:hidden"
            dropdown-class="left-0 mt-1 origin-top-left"
            button-class="block text-sm font-semibold text-left bg-transparent text-theme-secondary-700 dark:text-theme-secondary-200"
            :initial-value="$selected"
            :placeholder="$selected"
            :options="$options"
        />
        <p class="mt-3 text-lg font-bold sm:text-2xl text-theme-secondary-900 dark:text-theme-secondary-200">{{ $mainValue }}</p>
    </div>

    <div class="flex flex-col row-span-2 gap-5 pt-6 border-t sm:flex-row sm:row-span-1 sm:items-end md:pt-0 md:w-1/2 md:border-t-0 lg:justify-end xl:pt-6 xl:w-full xl:border-t border-theme-secondary-300 dark:border-theme-secondary-800">
        <div class="sm:w-1/3 md:w-7/12">
            <x-ark-rich-select
                wire:model="{{ $model }}"
                wrapper-class="relative left-0 md:hidden xl:inline-block"
                dropdown-class="left-0 mt-1 origin-top-left"
                button-class="block text-sm font-semibold text-left bg-transparent text-theme-secondary-700 dark:text-theme-secondary-200"
                :initial-value="$selected"
                :placeholder="$selected"
                :options="$options"
            />
            <h3 class="mt-4 mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $secondaryTitle }}</h3>
            <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200"
               @if($secondaryTooltip)
               data-tippy-content="{{ $secondaryTooltip }}"
               wire:key="{{ md5($secondaryTooltip) }}"
               @endif
            >
                {{ $secondaryValue }}
            </p>
        </div>

        @if($chart)
            <div class="flex flex-1 justify-end md:w-5/12">
                <x-chart
                    class="w-full h-auto"
                    id="stats-insight-{{ $id }}"
                    :data="collect($chart->get('datasets'))->toJson()"
                    :labels="collect($chart->get('labels'))->keys()->toJson()"
                    :theme="$chartTheme"
                    width="200"
                    height="50"
                />
            </div>
        @else
            <div class="sm:pl-6 sm:border-l sm:transform sm:-translate-x-6 md:w-5/12 md:-translate-x-8 lg:-translate-x-6 border-theme-secondary-300 dark:border-theme-secondary-800">
                <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $tertiaryTitle }}</h3>
                <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $tertiaryValue }}</p>
            </div>
        @endif
    </div>

</x-general.card>
