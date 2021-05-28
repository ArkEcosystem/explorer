@props([
    'title',
    'value',
    'title2',
    'value2',
    'title3' => null,
    'value3' => null,
    'chart' => null,
    'chartColor' => 'grey',
    'options',
])

<x-general.card with-border class="flex flex-col gap-6 md:flex-row xl:flex-col">
    <div class="md:w-1/2 xl:w-full">
        <h2 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-900 dark:text-theme-secondary-200">{{ $title }}</h2>
        <select {{ $attributes->wire('model') }} class="hidden mt-3 -ml-1 text-sm font-semibold bg-transparent appearance-none md:block xl:hidden text-theme-secondary-700 dark:text-theme-secondary-200">
            @foreach($options as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
        <p class="mt-3 text-lg font-bold sm:text-2xl text-theme-secondary-900 dark:text-theme-secondary-200">{{ $value }}</p>
    </div>

    <div class="border-t border-theme-secondary-300 dark:border-theme-secondary-800 pt-6 md:pt-0 md:border-t-0 xl:pt-6 xl:border-t row-span-2 sm:row-span-1 flex gap-5 flex-col sm:flex-row sm:items-end md:w-1/2 lg:justify-end xl:w-full">
        <div class="sm:w-2/5 md:w-1/2 lg:w-1/3 xl:w-1/2">
            <select {{ $attributes->wire('model') }} class="-ml-1 text-sm font-semibold bg-transparent appearance-none md:hidden xl:block text-theme-secondary-700 dark:text-theme-secondary-200">
                @foreach($options as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                @endforeach
            </select>
            <h3 class="mt-4 mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $title2 }}</h3>
            <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $value2 }}</p>
        </div>

        <div class="sm:w-3/5 md:w-1/2 lg:w-1/3 xl:w-1/2">
            @if($chart)
                <div class="flex-grow justify-end lg:flex" >
                    <div x-data="PriceChart(
                            {{ $chart->values()->toJson() }},
                            {{ $chart->keys()->toJson() }},
                            0,
                            true,
                            {{ Settings::usesDarkTheme() ? 'true' : 'false' }},
                            '{{ time() }}'
                        )"
                        x-init="init"
                        @toggle-dark-mode.window="toggleDarkMode"
                    >
                        <div class="relative">
                            <canvas wire:ignore x-ref="chart" class="w-full h-full" ></canvas>
                        </div>
                    </div>
                </div>
            @else
                <div class="border-theme-secondary-300 dark:border-theme-secondary-800 sm:border-l sm:pl-6">
                    <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $title3 }}</h3>
                    <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $value3 }}</p>
                </div>
            @endif
        </div>
    </div>

</x-general.card>
