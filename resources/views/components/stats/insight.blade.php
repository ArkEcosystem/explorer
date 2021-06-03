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
])

<x-general.card with-border class="flex flex-col gap-6 md:flex-row xl:flex-col">
    <div class="md:w-1/2 xl:w-full">
        <h2 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-900 dark:text-theme-secondary-200">{{ $mainTitle }}</h2>
        <label class="hidden relative mt-3 md:inline-block xl:hidden">
            <span class="flex absolute top-0 right-0 bottom-0 items-center transform translate-x-2 translate-y-px">
                <x-ark-icon name="chevron-down" size="2xs"/>
            </span>
            <select
                style="-moz-transform: translateX(-4px);"
                {{-- https://searchfox.org/mozilla-central/source/layout/style/res/forms.css#310 --}}
                {{-- https://bugzilla.mozilla.org/show_bug.cgi?id=1582545 --}}
                {{ $attributes->wire('model') }}
                class="text-sm font-semibold bg-transparent appearance-none text-theme-secondary-700 dark:text-theme-secondary-200">
                @foreach($options as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                @endforeach
            </select>
        </label>
        <p class="mt-3 text-lg font-bold sm:text-2xl text-theme-secondary-900 dark:text-theme-secondary-200">{{ $mainValue }}</p>
    </div>

    <div class="border-t border-theme-secondary-300 dark:border-theme-secondary-800 pt-6 md:pt-0 md:border-t-0 xl:pt-6 xl:border-t row-span-2 sm:row-span-1 flex gap-5 flex-col sm:flex-row sm:items-end md:w-1/2 lg:justify-end xl:w-full">
        <div class="sm:w-1/3 md:w-1/2">
            <label class="relative md:hidden xl:inline-block">
                <span class="flex absolute top-0 right-0 bottom-0 items-center transform translate-x-2 translate-y-px">
                    <x-ark-icon name="chevron-down" size="2xs"/>
                </span>
                <select
                    style="-moz-transform: translateX(-4px);"
                    {{-- https://searchfox.org/mozilla-central/source/layout/style/res/forms.css#310 --}}
                    {{-- https://bugzilla.mozilla.org/show_bug.cgi?id=1582545 --}}
                    {{ $attributes->wire('model') }}
                    class="text-sm font-semibold bg-transparent appearance-none text-theme-secondary-700 dark:text-theme-secondary-200">
                    @foreach($options as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <h3 class="mt-4 mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $secondaryTitle }}</h3>
            <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $secondaryValue }}</p>
        </div>

        @if($chart)
            <div class="md:w-1/2 flex flex-1 justify-end">
                <x-chart
                    class="w-full h-auto"
                    id="stats-insight-{{ $id }}"
                    :data="$chart->values()"
                    :labels="$chart->keys()"
                    :theme="$chartTheme"
                    width="200"
                    height="50"
                />
            </div>
        @else
            <div class="md:w-1/2 border-theme-secondary-300 dark:border-theme-secondary-800 sm:border-l sm:pl-6 md:pl-8">
                <h3 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-500 dark:text-theme-secondary-700">{{ $tertiaryTitle }}</h3>
                <p class="mt-2 text-base font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">{{ $tertiaryValue }}</p>
            </div>
        @endif
    </div>

</x-general.card>
