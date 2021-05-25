@props([
    'withoutBorder' => false,
    'icon'          => null,
    'tooltip'       => null,
    'url'           => null,
    'title',
    'text',
])

<div class="flex @if (! $withoutBorder) sm:border-r sm:border-theme-secondary-300 sm:mr-5 lg:mr-0 lg:pr-5 @endif h-11">
    @if ($icon)
        {{ $icon }}
    @endif

    <div class="flex flex-col justify-between font-semibold truncate">
        <div class="flex items-center">
            <div class="text-sm leading-tight text-theme-secondary-600 dark:text-theme-secondary-700">{{ $title }}</div>

            @if($tooltip)
                <x-ark-info :tooltip="$tooltip" class="ml-2 p-1.5" type="info" />
            @endif
        </div>

        @if ($url)
            <a href="{{ $url }}" class="flex leading-tight link mt-2">
                <span class="truncate w-full lg:text-right">{{ $text }}</span>
            </a>
        @else
            <span class="leading-tight truncate text-theme-secondary-900 dark:text-theme-secondary-200 mt-2">{{ $text }}</span>
        @endif
    </div>
</div>