@props([
    'responsive' => false,
    'breakpoint' => 'lg',
    'firstOn' => null,
    'lastOn' => null,
])

<x-ark-tables.cell
    :responsive="$responsive"
    :breakpoint="$breakpoint"
    :first-on="$firstOn"
    :last-on="$lastOn"
>
    <div class="flex items-center justify-between w-full md:flex-row md:space-x-3 md:justify-start">

        <div>
            <div class="w-6 h-6 rounded-full avatar-wrapper md:w-11 md:h-11 loading-state"></div>
        </div>

        <x-loading.text />
    </div>
</x-ark-tables.cell>
