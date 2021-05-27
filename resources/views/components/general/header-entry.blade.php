@props([
    'withoutBorder' => false,
    'icon'          => null,
    'tooltip'       => null,
    'url'           => null,
    'title',
    'text',
])

<div class="flex @if (! $withoutBorder) sm:border-r sm:border-theme-secondary-300 dark:border-theme-secondary-800 sm:mr-5 lg:mr-0 lg:pr-5 @endif">
    @if ($icon)
        {{ $icon }}
    @endif

    <div class="flex flex-col justify-between font-semibold leading-relaxed truncate">
        <div class="flex items-center">
            <div class="text-sm text-theme-secondary-500 dark:text-theme-secondary-700">{{ $title }}</div>

            @if($tooltip)
                <x-ark-info :tooltip="$tooltip" class="ml-2 p-1.5" type="info" />
            @endif
        </div>

        @if ($url)
            <a href="{{ $url }}" class="flex mt-2 link">
                <span class="w-full truncate lg:text-right">{{ $text }}</span>
            </a>
        @else
            <span class="mt-2 truncate text-theme-secondary-900 dark:text-theme-secondary-200">{{ $text }}</span>
        @endif
    </div>
</div>